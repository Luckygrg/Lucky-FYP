@extends('layouts.main')
@section('title', 'Add Service - SpaLush')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .dashboard-container { display: flex; min-height: 100vh; background: #1a1a1a; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 28px; color: white; font-weight: 300; font-family: 'Georgia', serif; letter-spacing: 1px; }
    .back-link { display: inline-flex; align-items: center; gap: 7px; color: #c9a961; text-decoration: none; font-size: 14px; margin-bottom: 20px; }
    .back-link:hover { color: #b8985a; }
    .form-card { background: #2a2a2a; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.3); padding: 35px 40px; max-width: 650px; border: 1px solid rgba(201,169,97,0.15); }
    .form-group { margin-bottom: 22px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.7); margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-group input, .form-group textarea, .form-group select {
        width: 100%; padding: 11px 14px; border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; font-size: 14px; color: rgba(255,255,255,0.9); transition: border-color 0.2s; background: #2d2d2d;
    }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #c9a961; background: #333; }
    .form-group textarea { min-height: 100px; resize: vertical; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-check { display: flex; align-items: center; gap: 10px; }
    .form-check input { width: auto; }
    .form-check label { text-transform: none; font-size: 14px; letter-spacing: 0; }
    .invalid-feedback { color: #e53935; font-size: 12px; margin-top: 4px; }
    .image-preview { margin-top: 10px; max-width: 200px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); display: none; }
    .btn-gold { padding: 12px 28px; background: #c9a961; color: white; border: none; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
    .btn-gold:hover { background: #b8985a; transform: translateY(-1px); }
    .btn-outline { padding: 12px 24px; background: transparent; color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; transition: all 0.3s; margin-left: 12px; }
    .btn-outline:hover { border-color: rgba(255,255,255,0.4); color: white; }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <a href="{{ route('spa_owner.services') }}" class="back-link">← Back to Services</a>

        <div class="page-header">
            <h1> Add New Service</h1>
        </div>

        <div class="form-card">
            <form action="{{ route('spa_owner.services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Service Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Swedish Massage" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" placeholder="Describe what this service includes...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Price (Rs.)</label>
                        <input type="number" name="price" value="{{ old('price') }}" placeholder="e.g. 800" min="0" step="0.01">
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Duration (minutes)</label>
                        <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}" placeholder="e.g. 60" min="1">
                        @error('duration_minutes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="spa_category_id">
                        <option value="">— Select Category —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('spa_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('spa_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Service Image</label>
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                           onchange="previewImage(this)">
                    <img id="image-preview" class="image-preview" src="" alt="Preview">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="is_available" id="is_available" value="1"
                               {{ old('is_available', '1') ? 'checked' : '' }}>
                        <label for="is_available">Available for booking</label>
                    </div>
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" class="btn-gold">Save Service</button>
                    <a href="{{ route('spa_owner.services') }}" class="btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
