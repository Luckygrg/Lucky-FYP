<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\Service;
use App\Models\SpaCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

            // Monthly revenue for the last 6 months
            $monthlyRevenue = \App\Models\Booking::where('spa_id', $spa->id)
                ->where('payment_status', 'paid')
                ->where('booking_date', '>=', now()->subMonths(5)->startOfMonth())
                ->select(
                    \Illuminate\Support\Facades\DB::raw("DATE_FORMAT(booking_date, '%Y-%m') as month"),
                    \Illuminate\Support\Facades\DB::raw('SUM(total_price) as revenue')
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->keyBy('month');

            // Build full 6-month array (fill missing months with 0)
            $revenueLabels = [];
            $revenueData   = [];
            for ($i = 5; $i >= 0; $i--) {
                $key = now()->subMonths($i)->format('Y-m');
                $revenueLabels[] = now()->subMonths($i)->format('M Y');
                $revenueData[]   = (float) ($monthlyRevenue[$key]->revenue ?? 0);
            }
        } else {
            $topServices    = collect();
            $revenueLabels  = [];
            $revenueData    = [];
        }

        return view('spa_owner.dashboard', compact(
            'spa', 'servicesCount', 'bookingsCount',
            'customersCount', 'totalEarning', 'recentCustomers', 'topServices',
            'revenueLabels', 'revenueData'
        ));
    }

    /* ── Dashboard Chart Data (AJAX) ──────────────────────────────────────── */

    public function chartData(Request $request)
    {
        $spa = Spa::where('user_id', Auth::id())->first();
        $period = $request->query('period', 'monthly');

        $revenueLabels = [];
        $revenueData   = [];
        $serviceLabels = [];
        $serviceData   = [];

        if ($spa) {
            $DB = \Illuminate\Support\Facades\DB::class;

            if ($period === 'daily') {
                // Last 14 days
                $rows = \App\Models\Booking::where('spa_id', $spa->id)
                    ->where('payment_status', 'paid')
                    ->where('booking_date', '>=', now()->subDays(13)->toDateString())
                    ->select(
                        $DB::raw("DATE(booking_date) as d"),
                        $DB::raw('SUM(total_price) as revenue')
                    )
                    ->groupBy('d')->orderBy('d')->get()->keyBy('d');

                for ($i = 13; $i >= 0; $i--) {
                    $date = now()->subDays($i);
                    $key  = $date->toDateString();
                    $revenueLabels[] = $date->format('d M');
                    $revenueData[]   = (float) ($rows[$key]->revenue ?? 0);
                }

                // Top services (last 14 days)
                $svcRows = \App\Models\BookingService::whereHas('booking', fn($q) => $q->where('spa_id', $spa->id)->where('booking_date', '>=', now()->subDays(13)->toDateString()))
                    ->select('service_name', $DB::raw('count(*) as total'))
                    ->groupBy('service_name')->orderByDesc('total')->limit(8)->get();

            } elseif ($period === 'weekly') {
                // Last 8 weeks
                $rows = \App\Models\Booking::where('spa_id', $spa->id)
                    ->where('payment_status', 'paid')
                    ->where('booking_date', '>=', now()->subWeeks(7)->startOfWeek()->toDateString())
                    ->select(
                        $DB::raw("DATE_FORMAT(booking_date, '%x-%v') as w"),
                        $DB::raw('SUM(total_price) as revenue')
                    )
                    ->groupBy('w')->orderBy('w')->get()->keyBy('w');

                for ($i = 7; $i >= 0; $i--) {
                    $weekStart = now()->subWeeks($i)->startOfWeek();
                    $key       = $weekStart->format('Y-W');
                    $isoKey    = $weekStart->format('o') . '-' . $weekStart->format('W');
                    $revenueLabels[] = $weekStart->format('d M');
                    $revenueData[]   = (float) ($rows[$isoKey]->revenue ?? $rows[$key]->revenue ?? 0);
                }

                // Top services (last 8 weeks)
                $svcRows = \App\Models\BookingService::whereHas('booking', fn($q) => $q->where('spa_id', $spa->id)->where('booking_date', '>=', now()->subWeeks(7)->startOfWeek()->toDateString()))
                    ->select('service_name', $DB::raw('count(*) as total'))
                    ->groupBy('service_name')->orderByDesc('total')->limit(8)->get();

            } else {
                // Monthly — last 6 months
                $rows = \App\Models\Booking::where('spa_id', $spa->id)
                    ->where('payment_status', 'paid')
                    ->where('booking_date', '>=', now()->subMonths(5)->startOfMonth())
                    ->select(
                        $DB::raw("DATE_FORMAT(booking_date, '%Y-%m') as m"),
                        $DB::raw('SUM(total_price) as revenue')
                    )
                    ->groupBy('m')->orderBy('m')->get()->keyBy('m');

                for ($i = 5; $i >= 0; $i--) {
                    $key = now()->subMonths($i)->format('Y-m');
                    $revenueLabels[] = now()->subMonths($i)->format('M Y');
                    $revenueData[]   = (float) ($rows[$key]->revenue ?? 0);
                }

                $svcRows = \App\Models\BookingService::whereHas('booking', fn($q) => $q->where('spa_id', $spa->id))
                    ->select('service_name', $DB::raw('count(*) as total'))
                    ->groupBy('service_name')->orderByDesc('total')->limit(8)->get();
            }

            $serviceLabels = $svcRows->pluck('service_name');
            $serviceData   = $svcRows->pluck('total');
        }

        return response()->json([
            'revenueLabels'  => $revenueLabels,
            'revenueData'    => $revenueData,
            'serviceLabels'  => $serviceLabels,
            'serviceData'    => $serviceData,
        ]);
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
            'price'            => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'spa_category_id'  => 'required|exists:spa_categories,id',
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
            'price'            => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'spa_category_id'  => 'required|exists:spa_categories,id',
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
                ->with(['customer:id,name,email,photo', 'booking:id,booking_date,total_price'])
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

        $customers = $spa
            ? \App\Models\Booking::where('spa_id', $spa->id)
                ->with('customer:id,name,email')
                ->select(
                    'user_id',
                    \Illuminate\Support\Facades\DB::raw('MAX(booking_date) as last_booking_date'),
                    \Illuminate\Support\Facades\DB::raw('COUNT(*) as bookings_count'),
                    \Illuminate\Support\Facades\DB::raw('SUM(total_price) as total_spent')
                )
                ->groupBy('user_id')
                ->orderByDesc('last_booking_date')
                ->get()
            : collect();

        return view('spa_owner.customers', compact('spa', 'customers'));
    }

    public function settings()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('spa_owner.settings', ['user' => $user]);
    }

    public function updateSettings(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $submittedSection = $request->input('update_section');
        $isPasswordUpdate = $request->filled('password');
        $hasProfileChanges = $request->hasFile('photo')
            || $request->input('name') !== $user->name
            || $request->input('email') !== $user->email;
        $isProfileUpdate = $submittedSection === 'profile'
            || ($submittedSection !== 'password' && $hasProfileChanges);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $photo = $request->file('photo');
            $path = $photo->store('avatars', 'public');
            $user->photo = $path;
        }

        $user->save();

        $successMessage = 'Settings updated successfully!';

        if ($isProfileUpdate && ! $isPasswordUpdate) {
            $successMessage = 'Profile info updated successfully!';
        } elseif ($isPasswordUpdate && ! $isProfileUpdate) {
            $successMessage = 'Password changed successfully!';
        }

        return redirect()->route('spa_owner.settings')
            ->with('success', $successMessage);
    }
}
