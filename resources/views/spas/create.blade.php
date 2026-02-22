@extends('layouts.main')

@section('title', 'Add Your Spa - SpaLush')

@section('content')

<style>
    .create-spa-container {
        max-width: 800px;
        margin: 60px auto;
        padding: 0 20px;
    }
    
    .create-spa-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .create-spa-header h1 {
        font-size: 36px;
        font-weight: 300;
        color: #1a1a1a;
        margin-bottom: 10px;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    
    .create-spa-header p {
        color: #666;
        font-size: 16px;
    }
    
    .spa-form {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-group label {
        display: block;
        color: #1a1a1a;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e8e8e8;
        border-radius: 8px;
        font-size: 15px;
        color: #1a1a1a;
        transition: all 0.3s ease;
    }
    
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #c9a961;
        box-shadow: 0 0 0 3px rgba(201, 169, 97, 0.1);
    }
    
    .form-group textarea {
        min-height: 120px;
        resize: vertical;
    }
    
    .form-group small {
        display: block;
        color: #999;
        font-size: 13px;
        margin-top: 6px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .submit-btn {
        width: 100%;
        padding: 16px;
        background: #c9a961;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 10px;
    }
    
    .submit-btn:hover {
        background: #b8985a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(201, 169, 97, 0.3);
    }
    
    .alert {
        padding: 15px 18px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 14px;
    }
    
    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .spa-form {
            padding: 30px 20px;
        }
    }
</style>

<div class="create-spa-container">
    <div class="create-spa-header">
        <h1>Add Your Spa</h1>
        <p>Share your wellness sanctuary with our community</p>
    </div>
    
    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Please fix the following errors:</strong>
            <ul style="margin: 10px 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('spas.store') }}" method="POST" class="spa-form">
        @csrf
        
        <div class="form-group">
            <label for="name">Spa Name *</label>
            <input 
                type="text" 
                id="name"
                name="name" 
                value="{{ old('name') }}" 
                placeholder="e.g., Serenity Wellness Spa" 
                required
            >
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="location">Location/Address *</label>
                <input 
                    type="text" 
                    id="location"
                    name="location" 
                    value="{{ old('location') }}" 
                    placeholder="e.g., Beverly Hills" 
                    required
                >
            </div>
            
            <div class="form-group">
                <label for="city">City *</label>
                <input 
                    type="text" 
                    id="city"
                    name="city" 
                    value="{{ old('city') }}" 
                    placeholder="e.g., Pokhara" 
                    required
                >
            </div>
        </div>
        
        <div class="form-group">
            <label for="description">Description *</label>
            <textarea 
                id="description"
                name="description" 
                placeholder="Describe your spa, services, and what makes it special..."
                required
            >{{ old('description') }}</textarea>
            <small>Tell customers about your spa's unique features and atmosphere</small>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="price_range">Price Range *</label>
                <select id="price_range" name="price_range" required>
                    <option value="">Select price range</option>
                    <option value="$" {{ old('price_range') == '$' ? 'selected' : '' }}>$ - Budget Friendly</option>
                    <option value="$$" {{ old('price_range') == '$$' ? 'selected' : '' }}>$$ - Moderate</option>
                    <option value="$$$" {{ old('price_range') == '$$$' ? 'selected' : '' }}>$$$ - Premium</option>
                    <option value="$$$$" {{ old('price_range') == '$$$$' ? 'selected' : '' }}>$$$$ - Luxury</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input 
                    type="text" 
                    id="phone"
                    name="phone" 
                    value="{{ old('phone') }}" 
                    placeholder="+977-9800000000"
                >
            </div>
        </div>
        
        <div class="form-group">
            <label for="email">Contact Email</label>
            <input 
                type="email" 
                id="email"
                name="email" 
                value="{{ old('email') }}" 
                placeholder="contact@yourspa.com"
            >
        </div>
        
        <div class="form-group">
            <label for="tags">Services/Tags</label>
            <input 
                type="text" 
                id="tags"
                name="tags" 
                value="{{ old('tags') }}" 
                placeholder="Massage, Facial, Yoga, Wellness"
            >
            <small>Separate multiple tags with commas</small>
        </div>
        
        <button type="submit" class="submit-btn">Create Spa Profile</button>
    </form>
</div>

@endsection
