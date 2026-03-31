@extends('layouts.main')
@section('title', 'Edit Service - SpaLush')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .dashboard-container { display: flex; min-height: 100vh; background: #FAF7F2; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 28px; color: #1C1008; font-weight: 300; font-family: 'Georgia', serif; }
    .back-link { display: inline-flex; align-items: center; gap: 7px; color: #C8916A; text-decoration: none; font-size: 14px; margin-bottom: 20px; }
    .back-link:hover { color: #AE7A55; }
    .form-card { background: #FFFFFF; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.3); padding: 35px 40px; max-width: 650px; border: 1px solid rgba(200,145,106,0.15); }
    .form-group { margin-bottom: 22px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: rgba(28,16,8,0.7); margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-group input, .form-group textarea, .form-group select {
        width: 100%; padding: 11px 14px; border: 1px solid rgba(28,16,8,0.15); border-radius: 6px; font-size: 14px; color: rgba(28,16,8,0.9); transition: border-color 0.2s; background: #F5EEE4;
    }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #C8916A; background: #F5EEE4; }
    .form-group textarea { min-height: 100px; resize: vertical; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-check { display: flex; align-items: center; gap: 10px; }
    .form-check input { width: auto; }
    .form-check label { text-transform: none; font-size: 14px; letter-spacing: 0; }
    .invalid-feedback { color: #e53935; font-size: 12px; margin-top: 4px; }
    .current-img { max-width: 200px; border-radius: 8px; border: 1px solid rgba(28,16,8,0.1); margin-bottom: 10px; display: block; }
    .image-preview { margin-top: 10px; max-width: 200px; border-radius: 8px; border: 1px solid rgba(28,16,8,0.1); display: none; }
    .remove-img-label { display: flex; align-items: center; gap: 8px; color: #e57373; font-size: 13px; cursor: pointer; margin-top: 8px; }
    .remove-img-label input { width: auto; accent-color: #e57373; }
    .btn-gold { padding: 12px 28px; background: #C8916A; color: #1C1008; border: none; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
    .btn-gold:hover { background: #AE7A55; transform: translateY(-1px); }
    .btn-outline { padding: 12px 24px; background: transparent; color: rgba(28,16,8,0.7); border: 1px solid rgba(28,16,8,0.2); border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; transition: all 0.3s; margin-left: 12px; }
    .btn-outline:hover { border-color: rgba(28,16,8,0.4); color: #1C1008; }
    .alert-success { background: rgba(200,145,106,0.1); color: #895D3E; padding: 14px 20px; border-radius: 6px; margin-bottom: 25px; border-left: 4px solid #C8916A; font-size: 14px; }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <a href="{{ route('spa_owner.services') }}" class="back-link">← Back to Services</a>

        <div class="page-header">
            <h1> Edit Service</h1>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="form-card">
            <form action="{{ route('spa_owner.services.update', $service) }}" method="POST" enctype="multipart/form-data">
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
                        <label>Price (Rs.)</label>
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
                    <select name="spa_category_id">
                        <option value="">— Select Category —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('spa_category_id', $service->spa_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('spa_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Service Image</label>
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="Current image" class="current-img" id="current-img">
                        <label class="remove-img-label">
                            <input type="checkbox" name="remove_image" value="1" onchange="toggleRemove(this)"> Remove current image
                        </label>
                    @endif
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                           style="margin-top:10px;" onchange="previewImage(this)">
                    <img id="image-preview" class="image-preview" src="" alt="Preview">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
function toggleRemove(checkbox) {
    const current = document.getElementById('current-img');
    if (current) current.style.opacity = checkbox.checked ? '0.3' : '1';
}
</script>
@endpush
@endsection
