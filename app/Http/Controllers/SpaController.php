<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpaController extends Controller
{
    /**
     * Display a listing of all spas (for customers)
     */
    public function index()
    {
        $spas = Spa::where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('is_featured', 'desc')
            ->orderBy('rating', 'desc')
            ->get();
            
        return view('spas.index', compact('spas'));
    }

    /**
     * Show the form for creating a new spa (for spa owners)
     */
    public function create()
    {
        if (Auth::user()->spa()->exists()) {
            return redirect()->route('spa_owner.dashboard')
                ->with('error', 'You already have a spa registered. Only one spa is allowed per owner.');
        }

        return view('spas.create');
    }

    /**
     * Store a newly created spa in storage
     */
    public function store(Request $request)
    {
        if (Auth::user()->spa()->exists()) {
            return redirect()->route('spa_owner.dashboard')
                ->with('error', 'You already have a spa registered. Only one spa is allowed per owner.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'required|string',
            'price_range' => 'required|in:$,$$,$$$,$$$$',
            'tags' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $tags = $request->tags ? explode(',', $request->tags) : [];
        $tags = array_map('trim', $tags);

        Spa::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'location' => $request->location,
            'city' => $request->city,
            'description' => $request->description,
            'price_range' => $request->price_range,
            'tags' => $tags,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->route('spa_owner.dashboard')
            ->with('success', 'Spa created successfully!');
    }

    /**
     * Display the specified spa
     */
    public function show(Spa $spa)
    {
        return view('spas.show', compact('spa'));
    }
}
