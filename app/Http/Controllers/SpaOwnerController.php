<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return view('spa_owner.dashboard', compact('spa', 'servicesCount'));
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
        $services = $spa->services()->orderBy('category')->orderBy('name')->get();

        return view('spa_owner.services.index', compact('spa', 'services'));
    }

    public function createService()
    {
        $spa = $this->ownedSpa();
        return view('spa_owner.services.create', compact('spa'));
    }

    public function storeService(Request $request)
    {
        $spa = $this->ownedSpa();

        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'category'         => 'nullable|string|max:100',
        ]);

        $spa->services()->create([
            'name'             => $request->name,
            'description'      => $request->description,
            'price'            => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'category'         => $request->category,
            'is_available'     => $request->boolean('is_available', true),
        ]);

        return redirect()->route('spa_owner.services')
            ->with('success', 'Service added successfully!');
    }

    public function editService(Service $service)
    {
        $spa = $this->ownedSpa();
        abort_unless($service->spa_id === $spa->id, 403);

        return view('spa_owner.services.edit', compact('spa', 'service'));
    }

    public function updateService(Request $request, Service $service)
    {
        $spa = $this->ownedSpa();
        abort_unless($service->spa_id === $spa->id, 403);

        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'category'         => 'nullable|string|max:100',
        ]);

        $service->update([
            'name'             => $request->name,
            'description'      => $request->description,
            'price'            => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'category'         => $request->category,
            'is_available'     => $request->boolean('is_available', true),
        ]);

        return redirect()->route('spa_owner.services')
            ->with('success', 'Service updated successfully!');
    }

    public function destroyService(Service $service)
    {
        $spa = $this->ownedSpa();
        abort_unless($service->spa_id === $spa->id, 403);

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

    public function schedule()
    {
        $spa = Spa::where('user_id', Auth::id())->first();
        return view('spa_owner.schedule', compact('spa'));
    }

    public function customers()
    {
        $spa = Spa::where('user_id', Auth::id())->first();
        return view('spa_owner.customers', compact('spa'));
    }

    public function settings()
    {
        return view('spa_owner.settings', ['user' => Auth::user()]);
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('spa_owner.settings')
            ->with('success', 'Settings updated successfully!');
    }
}
