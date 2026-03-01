@extends('layouts.main')
@section('title', 'Edit My Spa - SpaLush')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .dashboard-container { display: flex; min-height: 100vh; background: #f8f9fa; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 28px; color: #1a1a1a; font-weight: 300; font-family: 'Georgia', serif; letter-spacing: 1px; }
    .back-link { display: inline-flex; align-items: center; gap: 7px; color: #c9a961; text-decoration: none; font-size: 14px; margin-bottom: 20px; }
    .back-link:hover { color: #b8985a; }
    .alert-success { background: rgba(201,169,97,0.1); color: #8b7644; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; border-left: 4px solid #c9a961; font-size: 14px; }
    .alert-error  { background: #fce4ec; color: #c62828; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; border-left: 4px solid #e53935; font-size: 14px; }
    .form-card { background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 35px 40px; max-width: 750px; }
    .form-group { margin-bottom: 22px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #555; margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-group input, .form-group textarea, .form-group select {
        width: 100%; padding: 11px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 14px; color: #333; transition: border-color 0.2s; background: #fafafa;
    }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #c9a961; background: white; }
    .form-group textarea { min-height: 120px; resize: vertical; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .invalid-feedback { color: #e53935; font-size: 12px; margin-top: 4px; }
    .hint { color: #aaa; font-size: 12px; margin-top: 4px; }
    .current-image { display: flex; align-items: center; gap: 15px; margin-bottom: 12px; }
    .current-image img { width: 80px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #eee; }
    .btn-gold { padding: 12px 28px; background: #c9a961; color: white; border: none; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
    .btn-gold:hover { background: #b8985a; transform: translateY(-1px); }
    .btn-outline { padding: 12px 24px; background: transparent; color: #555; border: 1px solid #ccc; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; transition: all 0.3s; margin-left: 12px; }
    .btn-outline:hover { border-color: #999; color: #333; }
    .section-title { font-size: 16px; font-weight: 600; color: #c9a961; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 1px solid #f5f5f5; letter-spacing: 0.5px; }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <a href="{{ route('spa_owner.dashboard') }}" class="back-link">← Back to Dashboard</a>

        <div class="page-header">
            <h1>✏️ Edit My Spa</h1>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="form-card">
            <form action="{{ route('spa_owner.spa.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <p class="section-title">Basic Information</p>

                <div class="form-group">
                    <label>Spa Name *</label>
                    <input type="text" name="name" value="{{ old('name', $spa->name) }}">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Location / Address *</label>
                        <input type="text" name="location" value="{{ old('location', $spa->location) }}" >
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>City *</label>
                        <input type="text" name="city" value="{{ old('city', $spa->city) }}" required>
                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Description *</label>
                    <textarea name="description" required>{{ old('description', $spa->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Price Range *</label>
                        <select name="price_range" required>
                            @foreach(['$' => 'Budget ($)', '$$' => 'Mid-range ($$)', '$$$' => 'Upscale ($$$)', '$$$$' => 'Luxury ($$$$)'] as $val => $label)
                                <option value="{{ $val }}" {{ old('price_range', $spa->price_range) == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Opening Hours</label>
                        <input type="text" name="opening_hours" value="{{ old('opening_hours', $spa->opening_hours) }}" placeholder="e.g. Mon–Sun 9:00am–8:00pm">
                    </div>
                </div>

                <p class="section-title" style="margin-top:10px;">Contact</p>

                <div class="form-row">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $spa->phone) }}" placeholder="+977-9800000000">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $spa->email) }}" placeholder="spa@example.com">
                    </div>
                </div>

                <p class="section-title" style="margin-top:10px;">Tags &amp; Image</p>

                <div class="form-group">
                    <label>Tags</label>
                    <input type="text" name="tags" value="{{ old('tags', $spa->tags ? implode(', ', $spa->tags) : '') }}" placeholder="Massage, Facial, Yoga">
                    <div class="hint">Comma-separated tags shown on your spa listing.</div>
                </div>

                <div class="form-group">
                    <label>Cover Image</label>
                    @if($spa->image)
                        <div class="current-image">
                            <img src="{{ asset('storage/' . $spa->image) }}" alt="Current image">
                            <span style="color:#888; font-size:13px;">Current image — upload a new one to replace it.</span>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" class="btn-gold">Save Changes</button>
                    <a href="{{ route('spa_owner.dashboard') }}" class="btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
