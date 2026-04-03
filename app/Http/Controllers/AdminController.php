<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Spa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('admin.dashboard', compact(
            'totalSpaOwners',
            'totalCustomers',
            'totalSpas',
            'pendingSpas',
            'bookingsPerSpa',
            'bookingsPerCategory'
        ));
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
}
