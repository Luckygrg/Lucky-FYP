<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpaController extends Controller
{
    /**
     * Display a listing of all spas (for customers)
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $spas = Spa::where('is_active', true)
            ->where('status', 'approved')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('is_featured', 'desc')
            ->orderByDesc('reviews_avg_rating')
            ->get();
            
        return view('spas.index', compact('spas', 'search'));
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
        $spa->load('services.spaCategory');

        // Load reviews with the reviewer's name
        $reviews = $spa->reviews()
            ->with('customer:id,name')
            ->latest()
            ->get();

        $totalReviews = $reviews->count();
        $avgRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;

        // For authenticated customers: find completed bookings at this spa
        // that don't already have a review (they can still write one)
        $reviewableBookings = collect();
        $existingReview     = null;

        if (Auth::check() && Auth::user()->role === 'customer') {
            $reviewedBookingIds = $reviews
                ->where('user_id', Auth::id())
                ->pluck('booking_id');

            $reviewableBookings = Booking::where('user_id', Auth::id())
                ->where('spa_id', $spa->id)
                ->where('status', 'completed')
                ->whereNotIn('id', $reviewedBookingIds)
                ->get();

            $existingReview = $reviews->where('user_id', Auth::id())->first();
        }

        return view('spas.show', compact('spa', 'reviews', 'reviewableBookings', 'existingReview', 'avgRating', 'totalReviews'));
    }
}
