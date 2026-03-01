@extends('layouts.main')
@section('title', 'Edit Service - SpaLush')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .dashboard-container { display: flex; min-height: 100vh; background: #f8f9fa; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 28px; color: #1a1a1a; font-weight: 300; font-family: 'Georgia', serif; }
    .back-link { display: inline-flex; align-items: center; gap: 7px; color: #c9a961; text-decoration: none; font-size: 14px; margin-bottom: 20px; }
    .back-link:hover { color: #b8985a; }
    .form-card { background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 35px 40px; max-width: 650px; }
    .form-group { margin-bottom: 22px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #555; margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-group input, .form-group textarea, .form-group select {
        width: 100%; padding: 11px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 14px; color: #333; transition: border-color 0.2s; background: #fafafa;
    }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #c9a961; background: white; }
    .form-group textarea { min-height: 100px; resize: vertical; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-check { display: flex; align-items: center; gap: 10px; }
    .form-check input { width: auto; }
    .form-check label { text-transform: none; font-size: 14px; letter-spacing: 0; }
    .invalid-feedback { color: #e53935; font-size: 12px; margin-top: 4px; }
    .btn-gold { padding: 12px 28px; background: #c9a961; color: white; border: none; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
    .btn-gold:hover { background: #b8985a; transform: translateY(-1px); }
    .btn-outline { padding: 12px 24px; background: transparent; color: #555; border: 1px solid #ccc; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; transition: all 0.3s; margin-left: 12px; }
    .btn-outline:hover { border-color: #999; color: #333; }
    .alert-success { background: rgba(201,169,97,0.1); color: #8b7644; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; border-left: 4px solid #c9a961; font-size: 14px; }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <a href="{{ route('spa_owner.services') }}" class="back-link">← Back to Services</a>

        <div class="page-header">
            <h1>✏️ Edit Service</h1>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="form-card">
            <form action="{{ route('spa_owner.services.update', $service) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label>Service Name *</label>
                    <input type="text" name="name" value="{{ old('name', $service->name) }}" >
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description">{{ old('description', $service->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Price ($)</label>
                        <input type="number" name="price" value="{{ old('price', $service->price) }}" min="0" step="0.01">
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Duration (minutes)</label>
                        <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes) }}" min="1">
                        @error('duration_minutes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category">
                        <option value="">— Select Category —</option>
                        @foreach(['Massage', 'Facial', 'Body Treatment', 'Hydrotherapy', 'Yoga', 'Meditation', 'Nail Care', 'Hair Care', 'Other'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $service->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="is_available" id="is_available" value="1"
                               {{ old('is_available', $service->is_available) ? 'checked' : '' }}>
                        <label for="is_available">Available for booking</label>
                    </div>
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" class="btn-gold">Update Service</button>
                    <a href="{{ route('spa_owner.services') }}" class="btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
