<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Service;
use App\Models\Spa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Store a new booking (customer submits the booking form on spa page).
     */
    public function store(Request $request, Spa $spa)
    {
        $request->validate([
            'services'        => 'required|array|min:1',
            'services.*'      => 'exists:services,id',
            'booking_date'    => 'required|date|after_or_equal:today',
            'booking_time'    => 'required',
            'phone'           => 'required|string|max:20',
            'payment_option'  => 'required|in:pay_now,pay_later',
            'notes'           => 'nullable|string|max:1000',
        ]);

        // Fetch selected services (must belong to this spa)
        $selectedServices = Service::where('spa_id', $spa->id)
            ->whereIn('id', $request->services)
            ->where('is_available', true)
            ->get();

        if ($selectedServices->isEmpty()) {
            return back()->withErrors(['services' => 'No valid services selected.'])->withInput();
        }

        // Check: customer already has an active booking at this spa on the same date & time
        $duplicateBooking = Booking::where('user_id', Auth::id())
            ->where('spa_id', $spa->id)
            ->where('booking_date', $request->booking_date)
            ->where('booking_time', $request->booking_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($duplicateBooking) {
            return back()
                ->withErrors(['booking_time' => 'You already have an active booking at ' . $spa->name . ' on ' . \Carbon\Carbon::parse($request->booking_date)->format('d M Y') . ' at ' . \Carbon\Carbon::parse($request->booking_time)->format('h:i A') . '. Please choose a different date or time.'])
                ->withInput();
        }

        // Check: any of the selected services already booked at this spa on the same date & time
        $alreadyBookedServiceIds = BookingService::whereIn('service_id', $selectedServices->pluck('id'))
            ->whereHas('booking', function ($q) use ($request, $spa) {
                $q->where('spa_id', $spa->id)
                  ->where('booking_date', $request->booking_date)
                  ->where('booking_time', $request->booking_time)
                  ->whereIn('status', ['pending', 'confirmed']);
            })
            ->pluck('service_id')
            ->toArray();

        if (!empty($alreadyBookedServiceIds)) {
            $conflictNames = $selectedServices
                ->whereIn('id', $alreadyBookedServiceIds)
                ->pluck('name')
                ->join(', ');

            return back()
                ->withErrors(['services' => 'The following service(s) are already booked at this time: ' . $conflictNames . '. Please choose a different time.'])
                ->withInput();
        }

        $totalDuration = $selectedServices->sum('duration_minutes');
        $totalPrice    = $selectedServices->sum('price');

        DB::transaction(function () use ($request, $spa, $selectedServices, $totalDuration, $totalPrice) {
            $booking = Booking::create([
                'user_id'                => Auth::id(),
                'spa_id'                 => $spa->id,
                'phone'                  => $request->phone,
                'booking_date'           => $request->booking_date,
                'booking_time'           => $request->booking_time,
                'total_duration_minutes' => $totalDuration,
                'total_price'            => $totalPrice,
                'status'                 => 'pending',
                'payment_status'         => $request->payment_option === 'pay_now' ? 'paid' : 'unpaid',
                'payment_option'         => $request->payment_option,
                'notes'                  => $request->notes,
            ]);

            foreach ($selectedServices as $service) {
                BookingService::create([
                    'booking_id'       => $booking->id,
                    'service_id'       => $service->id,
                    'service_name'     => $service->name,
                    'price'            => $service->price,
                    'duration_minutes' => $service->duration_minutes,
                ]);
            }
        });

        return redirect()->route('customer.bookings')
            ->with('success', 'Your booking at ' . $spa->name . ' has been placed! We will confirm it shortly.');
    }

    /**
     * List bookings for the currently logged-in customer.
     */
    public function myBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['spa', 'bookingServices'])
            ->orderByDesc('booking_date')
            ->orderByDesc('created_at')
            ->get();

        return view('customer.bookings', compact('bookings'));
    }

    /**
     * Cancel a booking (customer cancels their own pending booking).
     */
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending bookings can be cancelled.']);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Spa owner: list all bookings for their spa.
     */
    public function ownerBookings()
    {
        $spa = Auth::user()->spa;

        if (!$spa) {
            return redirect()->route('spa_owner.dashboard')
                ->withErrors(['error' => 'No spa found for your account.']);
        }

        $bookings = Booking::where('spa_id', $spa->id)
            ->with(['customer', 'bookingServices'])
            ->orderByDesc('booking_date')
            ->orderByDesc('booking_time')
            ->get();

        return view('spa_owner.bookings', compact('spa', 'bookings'));
    }

    /**
     * Spa owner: update booking status (confirm / complete / cancel).
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $spa = Auth::user()->spa;

        if (!$spa || $booking->spa_id !== $spa->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated to ' . ucfirst($request->status) . '.');
    }
}

