<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\Service;
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

    public function services()
    {
        // Auto-sync any approved spa that has zero services
        $masterServices = Service::whereHas('spa', fn($q) => $q->where('status', 'approved'))
            ->get()
            ->unique('name');

        if ($masterServices->isNotEmpty()) {
            $emptyApprovedSpas = Spa::where('status', 'approved')
                ->doesntHave('services')
                ->get();

            foreach ($emptyApprovedSpas as $spa) {
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

        $spas = Spa::where('status', 'approved')
            ->with(['services' => function ($q) {
                $q->where('is_available', true)->with('spaCategory')->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        return view('customer.services', compact('spas'));
    }
}
