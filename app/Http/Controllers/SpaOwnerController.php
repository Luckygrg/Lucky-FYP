<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use App\Models\Service;
use App\Models\SpaCategory;
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

        // If this approved spa has no services yet, sync from other approved spas
        if ($spa->status === 'approved' && $spa->services()->count() === 0) {
            $existingServices = Service::whereHas('spa', fn($q) => $q->where('status', 'approved'))
                ->where('spa_id', '!=', $spa->id)
                ->get()
                ->unique('name');

            foreach ($existingServices as $source) {
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

        $services = $spa->services()->with('spaCategory')->orderBy('name')->get();

        return view('spa_owner.services.index', compact('spa', 'services'));
    }

    public function createService()
    {
        $spa = $this->ownedSpa();
        $categories = SpaCategory::all();
        return view('spa_owner.services.create', compact('spa', 'categories'));
    }

    public function storeService(Request $request)
    {
        $spa = $this->ownedSpa();

        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'spa_category_id'  => 'nullable|exists:spa_categories,id',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'             => $request->name,
            'description'      => $request->description,
            'price'            => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'spa_category_id'  => $request->spa_category_id ?: null,
            'is_available'     => $request->boolean('is_available', true),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        // Create the service for the owner's spa
        $spa->services()->create($data);

        // Replicate to all other approved spas that don't already have a service with this name
        $otherApprovedSpas = Spa::where('status', 'approved')
            ->where('id', '!=', $spa->id)
            ->get();

        foreach ($otherApprovedSpas as $approvedSpa) {
            $alreadyExists = $approvedSpa->services()
                ->where('name', $data['name'])
                ->exists();

            if (!$alreadyExists) {
                $approvedSpa->services()->create($data);
            }
        }

        return redirect()->route('spa_owner.services')
            ->with('success', 'Service added successfully to all approved spas!');
    }

    public function editService(Service $service)
    {
        $spa = $this->ownedSpa();
        $categories = SpaCategory::all();
        return view('spa_owner.services.edit', compact('spa', 'service', 'categories'));
    }

    public function updateService(Request $request, Service $service)
    {
        $spa = $this->ownedSpa();

        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'price'            => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'spa_category_id'  => 'nullable|exists:spa_categories,id',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'             => $request->name,
            'description'      => $request->description,
            'price'            => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'spa_category_id'  => $request->spa_category_id ?: null,
            'is_available'     => $request->boolean('is_available', true),
        ];

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        if ($request->boolean('remove_image') && $service->image) {
            Storage::disk('public')->delete($service->image);
            $data['image'] = null;
        }

        $oldName = $service->name;

        $service->update($data);

        // Propagate update to the same-named service across all other approved spas
        Service::whereHas('spa', fn($q) => $q->where('status', 'approved'))
            ->where('spa_id', '!=', $service->spa_id)
            ->where('name', $oldName)
            ->get()
            ->each(function ($replica) use ($data) {
                // Keep each spa's own image unless a new one was uploaded
                $updateData = $data;
                if (!isset($updateData['image'])) {
                    unset($updateData['image']);
                }
                $replica->update($updateData);
            });

        return redirect()->route('spa_owner.services')
            ->with('success', 'Service updated successfully across all approved spas!');
    }

    public function destroyService(Service $service)
    {
        $spa = $this->ownedSpa();

        $serviceName = $service->name;
        $serviceImage = $service->image;

        // Delete matching services from all other approved spas first
        Service::whereHas('spa', fn($q) => $q->where('status', 'approved'))
            ->where('spa_id', '!=', $service->spa_id)
            ->where('name', $serviceName)
            ->get()
            ->each(function ($replica) {
                // Don't delete the image file here — the primary record handles it
                $replica->delete();
            });

        if ($serviceImage) {
            Storage::disk('public')->delete($serviceImage);
        }

        $service->delete();

        return redirect()->route('spa_owner.services')
            ->with('success', 'Service deleted from all approved spas!');
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
