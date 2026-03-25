<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\Service;
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
     * Approve a spa — and sync all existing services from other approved spas into it.
     */
    public function approveSpa(Spa $spa)
    {
        $spa->update(['status' => 'approved', 'is_active' => true]);

        // Collect one representative copy of each service (by name) from all currently approved spas
        $existingServices = Service::whereHas('spa', fn($q) => $q->where('status', 'approved'))
            ->where('spa_id', '!=', $spa->id)
            ->get()
            ->unique('name');

        foreach ($existingServices as $source) {
            $alreadyExists = $spa->services()->where('name', $source->name)->exists();
            if (!$alreadyExists) {
                $spa->services()->create([
                    'name'             => $source->name,
                    'description'      => $source->description,
                    'price'            => $source->price,
                    'duration_minutes' => $source->duration_minutes,
                    'spa_category_id'  => $source->spa_category_id,
                    'is_available'     => $source->is_available,
                    'image'            => $source->image,
                ]);
            }
        }

        return back()->with('success', "Spa '{$spa->name}' has been approved and synced with all existing services.");
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
        $approvedSpas = Spa::where('status', 'approved')->with('services')->get();

        // Get one copy of every distinct service name from spas that DO have services
        $masterServices = Service::whereHas('spa', fn($q) => $q->where('status', 'approved'))
            ->get()
            ->unique('name');

        if ($masterServices->isNotEmpty()) {
            foreach ($approvedSpas as $spa) {
                if ($spa->services->isEmpty()) {
                    foreach ($masterServices as $source) {
                        $spa->services()->create([
                            'name'             => $source->name,
                            'description'      => $source->description,
                            'price'            => $source->price,
                            'duration_minutes' => $source->duration_minutes,
                            'spa_category_id'  => $source->spa_category_id,
                            'is_available'     => $source->is_available,
                            'image'            => $source->image,
                        ]);
                    }
                }
            }
        }

        $spas = Spa::where('status', 'approved')
            ->with('services.spaCategory')
            ->orderBy('name')
            ->get();

        return view('admin.services', compact('spas'));
    }
}
