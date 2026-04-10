<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\Service;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Review;
use App\Models\SpaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Show customer dashboard
     */
    public function dashboard()
    {
        return redirect()->route('customer.profile');
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

    public function profile()
    {
        $user = Auth::user();
        $bookingsCount = Booking::where('user_id', $user->id)->count();
        $paymentsCount = Payment::where('user_id', $user->id)->count();
        $reviewsCount = Review::where('user_id', $user->id)->count();

        return view('customer.profile', compact('user', 'bookingsCount', 'paymentsCount', 'reviewsCount'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Handle photo removal
        if ($request->has('remove_photo') && $user->photo) {
            Storage::disk('public')->delete($user->photo);
            $user->photo = null;
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profile-photos', 'public');
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function paymentHistory()
    {
        $payments = Payment::where('user_id', Auth::id())
            ->with(['booking.bookingServices', 'booking.spa'])
            ->orderByDesc('created_at')
            ->get();

        return view('customer.payments', compact('payments'));
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(20);

        return view('customer.notifications', compact('notifications'));
    }
}
