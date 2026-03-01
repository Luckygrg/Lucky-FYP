<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\User;
use Illuminate\Http\Request;

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

        return view('admin.dashboard', compact(
            'totalSpaOwners',
            'totalCustomers',
            'totalSpas',
            'pendingSpas'
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
     * Approve a spa
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
     * Show all approved spas and their services
     */
    public function services()
    {
        $spas = Spa::where('status', 'approved')
            ->with('services')
            ->orderBy('name')
            ->get();

        return view('admin.services', compact('spas'));
    }
}
