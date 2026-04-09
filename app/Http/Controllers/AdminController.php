<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingService;
use App\Models\ContactMessage;
use App\Models\Spa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show admin dashboard with real stats
     */
    public function dashboard()
    {
        $totalSpaOwners  = User::where('role', 'spa_owner')->count();
        $totalCustomers  = User::where('role', 'customer')->count();
        $totalSpas       = Spa::where('status', 'approved')->count();
        $pendingSpas     = Spa::where('status', 'pending')->count();

        // Chart 1: bookings per spa
        $bookingsPerSpa = Booking::select('spa_id', DB::raw('count(*) as total'))
            ->groupBy('spa_id')
            ->with('spa:id,name')
            ->get()
            ->map(fn($b) => ['spa' => $b->spa->name ?? 'Unknown', 'total' => $b->total]);

        // Chart 2: most used categories (via booking_services -> services -> spa_categories)
        $bookingsPerCategory = BookingService::join('services', 'booking_services.service_id', '=', 'services.id')
            ->join('spa_categories', 'services.spa_category_id', '=', 'spa_categories.id')
            ->select('spa_categories.name as category', DB::raw('count(*) as total'))
            ->groupBy('spa_categories.name')
            ->orderByDesc('total')
            ->get();

        $recentMessages = ContactMessage::latest()->take(5)->get();
        $unreadCount    = ContactMessage::where('is_read', false)->count();

        return view('admin.dashboard', compact(
            'totalSpaOwners',
            'totalCustomers',
            'totalSpas',
            'pendingSpas',
            'bookingsPerSpa',
            'bookingsPerCategory',
            'recentMessages',
            'unreadCount'
        ));
    }

    /**
     * Chart data for admin dashboard (AJAX)
     */
    public function chartData(Request $request)
    {
        $period = $request->query('period', 'monthly');

        if ($period === 'daily') {
            $dateFilter = now()->subDays(13)->toDateString();
        } elseif ($period === 'weekly') {
            $dateFilter = now()->subWeeks(7)->startOfWeek()->toDateString();
        } else {
            $dateFilter = now()->subMonths(5)->startOfMonth()->toDateString();
        }

        // Bookings per spa (filtered by period)
        $spaData = Booking::where('booking_date', '>=', $dateFilter)
            ->select('spa_id', DB::raw('count(*) as total'))
            ->groupBy('spa_id')
            ->with('spa:id,name')
            ->get()
            ->map(fn($b) => ['spa' => $b->spa->name ?? 'Unknown', 'total' => $b->total]);

        // Most used categories (filtered by period)
        $categoryData = BookingService::join('services', 'booking_services.service_id', '=', 'services.id')
            ->join('spa_categories', 'services.spa_category_id', '=', 'spa_categories.id')
            ->join('bookings', 'booking_services.booking_id', '=', 'bookings.id')
            ->where('bookings.booking_date', '>=', $dateFilter)
            ->select('spa_categories.name as category', DB::raw('count(*) as total'))
            ->groupBy('spa_categories.name')
            ->orderByDesc('total')
            ->get();

        return response()->json([
            'spaLabels'      => $spaData->pluck('spa'),
            'spaData'        => $spaData->pluck('total'),
            'categoryLabels' => $categoryData->pluck('category'),
            'categoryData'   => $categoryData->pluck('total'),
        ]);
    }

    /**
     * List all spa owners with their spa
     */
    public function spaOwners(Request $request)
    {
        $spaOwners = User::where('role', 'spa_owner')
            ->with('spa')
            ->latest()
            ->get();

        return view('admin.spa_owners', compact('spaOwners'));
    }

    /**
     * Show a single spa owner and their spa details
     */
    public function showSpaOwner(User $user)
    {
        $user->load('spa');
        return view('admin.spa_owner_show', compact('user'));
    }

    /**
     * Approve a spa — and sync all existing services from other approved spas into it.
     */
    public function approveSpa(Spa $spa)
    {
        $spa->update(['status' => 'approved', 'is_active' => true]);

        return back()->with('success', "Spa '{$spa->name}' has been approved.");
    }

    /**
     * Disapprove a spa
     */
    public function disapproveSpa(Spa $spa)
    {
        $spa->update(['status' => 'disapproved', 'is_active' => false]);
        return back()->with('error', "Spa '{$spa->name}' has been disapproved.");
    }

    /**
     * Show all approved spas and their services.
     * Auto-syncs any approved spa that has zero services.
     */
    public function services()
    {
        $spas = Spa::where('status', 'approved')
            ->with('services.spaCategory')
            ->orderBy('name')
            ->get();

        return view('admin.services', compact('spas'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        Auth::user()->update($request->only('name', 'email'));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }
}
