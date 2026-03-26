<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\Service;
use App\Models\SpaCategory;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Show customer dashboard
     */
    public function dashboard()
    {
        return view('customer.dashboard');
    }

    public function services(Request $request)
    {
        $categories = SpaCategory::orderBy('name')->get();

        $selectedCategory = $request->query('category');

        // Get unique services (by name) that are available, filtered by category if selected
        $servicesQuery = Service::whereHas('spa', fn($q) => $q->where('status', 'approved'))
            ->where('is_available', true)
            ->with('spaCategory');

        if ($selectedCategory) {
            $servicesQuery->whereHas('spaCategory', fn($q) => $q->where('id', $selectedCategory));
        }

        // One entry per unique service name
        $services = $servicesQuery->get()->unique('name')->sortBy('name')->values();

        $totalServices = Service::whereHas('spa', fn($q) => $q->where('status', 'approved'))
            ->where('is_available', true)
            ->distinct('name')
            ->count('name');

        return view('customer.services', compact('categories', 'services', 'selectedCategory', 'totalServices'));
    }
}
