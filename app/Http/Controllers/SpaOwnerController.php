<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\Service;
use App\Models\SpaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SpaOwnerController extends Controller
{
    /** Ensure the authenticated user owns the given spa */
    private function ownedSpa()
    {
        return Spa::where('user_id', Auth::id())->firstOrFail();
    }

    /* ── Dashboard ──────────────────────────────────────────────────────────── */

    public function dashboard()
    {
        $spa = Spa::where('user_id', Auth::id())->first();
        $servicesCount = $spa ? $spa->services()->count() : 0;

        $bookingsCount   = 0;
        $customersCount  = 0;
        $totalEarning    = 0;
        $recentCustomers = collect();

        if ($spa) {
            // Auto-complete confirmed bookings whose date+time has passed
            $now = now();
            \App\Models\Booking::where('spa_id', $spa->id)
                ->where('status', 'confirmed')
                ->where(function ($q) use ($now) {
                    $q->where('booking_date', '<', $now->toDateString())
                      ->orWhere(function ($q2) use ($now) {
                          $q2->where('booking_date', '=', $now->toDateString())
                             ->where('booking_time', '<=', $now->toTimeString());
                      });
                })
                ->update(['status' => 'completed']);

            $bookingsQuery = \App\Models\Booking::where('spa_id', $spa->id);

            $bookingsCount  = $bookingsQuery->count();
            $customersCount = $bookingsQuery->distinct('user_id')->count('user_id');
            $totalEarning   = \App\Models\Booking::where('spa_id', $spa->id)
                                ->where('payment_status', 'paid')
                                ->sum('total_price');

            // Recent unique customers with their last booking date and total booking count
            $recentCustomers = \App\Models\Booking::where('spa_id', $spa->id)
                ->with('customer')
                ->select('user_id',
                    \Illuminate\Support\Facades\DB::raw('MAX(booking_date) as last_booking'),
                    \Illuminate\Support\Facades\DB::raw('COUNT(*) as total_bookings')
                )
                ->groupBy('user_id')
                ->orderByDesc('last_booking')
                ->limit(10)
                ->get();
            // Most booked services for this spa
            $topServices = \App\Models\BookingService::whereHas('booking', fn($q) => $q->where('spa_id', $spa->id))
                ->select('service_name', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('service_name')
                ->orderByDesc('total')
                ->limit(8)
                ->get();
        } else {
            $topServices = collect();
        }

        return view('spa_owner.dashboard', compact(
            'spa', 'servicesCount', 'bookingsCount',
            'customersCount', 'totalEarning', 'recentCustomers', 'topServices'
        ));
    }

    /* ── Edit / Update Spa ───────────────────────────────────────────────────── */

    public function editSpa()
    {
        $spa = $this->ownedSpa();
        return view('spa_owner.spa_edit', compact('spa'));
    }

    public function updateSpa(Request $request)
    {
        $spa = $this->ownedSpa();

        $request->validate([
            'name'        => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'city'        => 'required|string|max:255',
            'description' => 'required|string',
            'price_range' => 'required|in:$,$$,$$$,$$$$',
            'tags'        => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'opening_hours' => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $tags = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];

        $data = [
            'name'          => $request->name,
            'location'      => $request->location,
            'city'          => $request->city,
            'description'   => $request->description,
            'price_range'   => $request->price_range,
            'tags'          => $tags,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'opening_hours' => $request->opening_hours,
        ];

        if ($request->hasFile('image')) {
            if ($spa->image) {
                Storage::disk('public')->delete($spa->image);
            }
            $data['image'] = $request->file('image')->store('spas', 'public');
        }

        $spa->update($data);

        return redirect()->route('spa_owner.spa.edit')
            ->with('success', 'Spa updated successfully!');
    }

    /* ── Services ────────────────────────────────────────────────────────────── */

    public function services()
    {
        $spa = $this->ownedSpa();

        $services = $spa->services()->with('spaCategory')->orderBy('name')->get();

        return view('spa_owner.services.index', compact('spa', 'services'));
    }

    public function createService()
    {
        $spa = $this->ownedSpa();
        $categories = SpaCategory::all();
        return view('spa_owner.services.create', compact('spa', 'categories'));
    }

    public function storeService(Request $request)
    {
        $spa = $this->ownedSpa();

        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'spa_category_id'  => 'nullable|exists:spa_categories,id',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'             => $request->name,
            'description'      => $request->description,
            'price'            => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'spa_category_id'  => $request->spa_category_id ?: null,
            'is_available'     => $request->boolean('is_available', true),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        // Create the service for the owner's spa only
        $spa->services()->create($data);

        return redirect()->route('spa_owner.services')
            ->with('success', 'Service added successfully!');
    }

    public function editService(Service $service)
    {
        $spa = $this->ownedSpa();
        $categories = SpaCategory::all();
        return view('spa_owner.services.edit', compact('spa', 'service', 'categories'));
    }

    public function updateService(Request $request, Service $service)
    {
        $spa = $this->ownedSpa();

        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'spa_category_id'  => 'nullable|exists:spa_categories,id',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'             => $request->name,
            'description'      => $request->description,
            'price'            => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'spa_category_id'  => $request->spa_category_id ?: null,
            'is_available'     => $request->boolean('is_available', true),
        ];

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        if ($request->boolean('remove_image') && $service->image) {
            Storage::disk('public')->delete($service->image);
            $data['image'] = null;
        }

        $service->update($data);

        return redirect()->route('spa_owner.services')
            ->with('success', 'Service updated successfully!');
    }

    public function destroyService(Service $service)
    {
        $spa = $this->ownedSpa();

        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('spa_owner.services')
            ->with('success', 'Service deleted successfully!');
    }

    /* ── Placeholder Pages ───────────────────────────────────────────────────── */

    public function bookings()
    {
        $spa = Spa::where('user_id', Auth::id())->first();
        return view('spa_owner.bookings', compact('spa'));
    }

    public function payments()
    {
        $spa = Spa::where('user_id', Auth::id())->first();

        $payments = \App\Models\Payment::with(['booking.bookingServices', 'user'])
            ->whereHas('booking', fn($q) => $q->where('spa_id', optional($spa)->id))
            ->latest('paid_at')
            ->get();

        $totalRevenue    = $payments->where('status', 'completed')->sum('amount');
        $totalPaid       = $payments->where('status', 'completed')->count();
        $totalPending    = $payments->where('status', 'pending')->count();

        return view('spa_owner.payments', compact('spa', 'payments', 'totalRevenue', 'totalPaid', 'totalPending'));
    }

    public function reviews()
    {
        $spa = Spa::where('user_id', Auth::id())->first();

        $reviews = $spa
            ? \App\Models\Review::where('spa_id', $spa->id)
                ->with(['customer:id,name,email', 'booking:id,booking_date,total_price'])
                ->latest()
                ->get()
            : collect();

        $avgRating   = $reviews->avg('rating') ?? 0;
        $totalCount  = $reviews->count();
        $starCounts  = [];
        for ($i = 5; $i >= 1; $i--) {
            $starCounts[$i] = $reviews->where('rating', $i)->count();
        }

        return view('spa_owner.reviews', compact('spa', 'reviews', 'avgRating', 'totalCount', 'starCounts'));
    }

    public function customers()
    {
        $spa = Spa::where('user_id', Auth::id())->first();
        return view('spa_owner.customers', compact('spa'));
    }

    public function settings()
    {
        return view('spa_owner.settings', ['user' => Auth::user()]);
    }

    public function updateSettings(Request $request)
    {
        // dd($request);
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('avatars', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->route('spa_owner.settings')
            ->with('success', 'Settings updated successfully!');
    }
}
