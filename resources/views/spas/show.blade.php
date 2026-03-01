@extends('layouts.main')

@section('title', $spa->name . ' - SpaLush')

@section('content')

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    .spa-hero {
        background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
                    url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1920') center/cover;
        padding: 100px 20px;
        text-align: center;
        color: white;
    }

    .spa-hero h1 {
        font-size: 48px;
        font-weight: 300;
        letter-spacing: 3px;
        margin-bottom: 12px;
        font-family: 'Georgia', serif;
    }

    .spa-hero p {
        font-size: 18px;
        font-weight: 300;
        opacity: 0.85;
    }

    .spa-show-container {
        max-width: 1100px;
        margin: 60px auto;
        padding: 0 30px;
    }

    /* Back link */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #c9a961;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 30px;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #b8985a;
    }

    /* Status banner */
    .status-banner {
        padding: 14px 20px;
        border-radius: 6px;
        margin-bottom: 30px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-banner.pending {
        background: #fff8e1;
        color: #8b6914;
        border-left: 4px solid #f0b429;
    }

    .status-banner.approved {
        background: #e8f5e9;
        color: #2e7d32;
        border-left: 4px solid #43a047;
    }

    .status-banner.disapproved {
        background: #fce4ec;
        color: #c62828;
        border-left: 4px solid #e53935;
    }

    /* Main card */
    .spa-card-main {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.07);
        overflow: hidden;
        margin-bottom: 35px;
    }

    .spa-image-wrap {
        width: 100%;
        height: 340px;
        background: linear-gradient(135deg, #c9a961 0%, #8b7644 100%);
        overflow: hidden;
        position: relative;
    }

    .spa-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .spa-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 80px;
        color: rgba(255,255,255,0.5);
    }

    .featured-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: #c9a961;
        color: white;
        padding: 7px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .price-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: white;
        color: #1a1a1a;
        padding: 7px 14px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 700;
    }

    .spa-details {
        padding: 35px 40px;
    }

    .spa-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .spa-meta-row h2 {
        font-size: 32px;
        font-weight: 400;
        color: #1a1a1a;
        font-family: 'Georgia', serif;
        flex: 1;
    }

    .spa-rating {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .rating-star { color: #c9a961; font-size: 18px; }
    .rating-number { font-weight: 700; font-size: 18px; color: #1a1a1a; }
    .rating-count { color: #999; font-size: 14px; }

    .spa-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 18px;
        margin-bottom: 25px;
    }

    .spa-info-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: #555;
        font-size: 14px;
    }

    .spa-info-item i {
        color: #c9a961;
        margin-top: 2px;
        width: 16px;
        flex-shrink: 0;
    }

    .spa-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 25px;
    }

    .spa-tag {
        background: #f5f5f5;
        color: #666;
        padding: 5px 14px;
        border-radius: 14px;
        font-size: 13px;
    }

    .section-divider {
        border: none;
        border-top: 1px solid #f0f0f0;
        margin: 25px 0;
    }

    .section-label {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #c9a961;
        margin-bottom: 12px;
    }

    .spa-description-text {
        color: #555;
        font-size: 15px;
        line-height: 1.8;
    }

    /* Services */
    .services-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.07);
        padding: 35px 40px;
        margin-bottom: 35px;
    }

    .services-section h3 {
        font-size: 22px;
        font-weight: 300;
        color: #1a1a1a;
        font-family: 'Georgia', serif;
        margin-bottom: 25px;
        letter-spacing: 1px;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }

    .service-card {
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        padding: 22px;
        transition: all 0.3s;
    }

    .service-card:hover {
        border-color: #c9a961;
        box-shadow: 0 4px 12px rgba(201,169,97,0.12);
    }

    .service-name {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .service-desc {
        font-size: 13px;
        color: #888;
        line-height: 1.6;
        margin-bottom: 14px;
    }

    .service-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
    }

    .service-duration {
        color: #999;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .service-price {
        font-weight: 700;
        color: #c9a961;
        font-size: 15px;
    }

    .no-services {
        text-align: center;
        padding: 40px 20px;
        color: #bbb;
        font-size: 15px;
    }

    /* Owner actions */
    .owner-actions {
        background: #fffdf5;
        border: 1px solid #f0e8ce;
        border-radius: 10px;
        padding: 25px 30px;
        margin-bottom: 35px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }

    .owner-actions p {
        font-size: 14px;
        color: #8b7644;
    }

    .owner-actions-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-gold {
        padding: 10px 22px;
        background: #c9a961;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .btn-gold:hover {
        background: #b8985a;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(201,169,97,0.3);
    }

    .btn-dark {
        padding: 10px 22px;
        background: #1a1a1a;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .btn-dark:hover {
        background: #333;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .spa-hero h1 { font-size: 32px; }
        .spa-details { padding: 25px 20px; }
        .services-section { padding: 25px 20px; }
        .owner-actions { flex-direction: column; }
    }
</style>

<!-- Hero -->
<section class="spa-hero">
    <h1>{{ $spa->name }}</h1>
    <p>{{ $spa->city }}</p>
</section>

<div class="spa-show-container">

    <!-- Back link -->
    @auth
        @if(Auth::user()->role === 'spa_owner' && $spa->user_id === Auth::id())
            <a href="{{ route('spa_owner.dashboard') }}" class="back-link">
                <i class="fas fa-chevron-left"></i> Back to Dashboard
            </a>
        @else
            <a href="{{ route('spas.index') }}" class="back-link">
                <i class="fas fa-chevron-left"></i> Back to All Spas
            </a>
        @endif
    @else
        <a href="{{ route('spas.index') }}" class="back-link">
            <i class="fas fa-chevron-left"></i> Back to All Spas
        </a>
    @endauth

    <!-- Approval status banner (only visible to the spa owner) -->
    @auth
        @if(Auth::user()->role === 'spa_owner' && $spa->user_id === Auth::id())
            @if($spa->status === 'pending')
                <div class="status-banner pending">
                    <i class="fas fa-clock"></i>
                    Your spa is <strong>pending approval</strong>. It will be visible to customers once an admin approves it.
                </div>
            @elseif($spa->status === 'approved')
                <div class="status-banner approved">
                    <i class="fas fa-check-circle"></i>
                    Your spa is <strong>approved</strong> and visible to customers.
                </div>
            @elseif($spa->status === 'disapproved')
                <div class="status-banner disapproved">
                    <i class="fas fa-times-circle"></i>
                    Your spa has been <strong>disapproved</strong>. Please contact support for more details.
                </div>
            @endif
        @endif
    @endauth

    <!-- Owner quick-actions bar -->
    @auth
        @if(Auth::user()->role === 'spa_owner' && $spa->user_id === Auth::id())
            <div class="owner-actions">
                <p><i class="fas fa-user-tie"></i> &nbsp;You are viewing your own spa listing.</p>
                <div class="owner-actions-buttons">
                    <a href="{{ route('spa_owner.dashboard') }}" class="btn-dark">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </div>
            </div>
        @endif
    @endauth

    <!-- Spa main card -->
    <div class="spa-card-main">
        <div class="spa-image-wrap">
            @if($spa->image)
                <img src="{{ asset('storage/' . $spa->image) }}" alt="{{ $spa->name }}">
            @else
                <div class="spa-image-placeholder">
                    <i class="fas fa-spa"></i>
                </div>
            @endif

            @if($spa->is_featured)
                <div class="featured-badge"><i class="fas fa-star"></i> Featured</div>
            @endif

            @if($spa->price_range)
                <div class="price-badge">{{ $spa->price_range }}</div>
            @endif
        </div>

        <div class="spa-details">
            <div class="spa-meta-row">
                <h2>{{ $spa->name }}</h2>
                <div class="spa-rating">
                    <i class="fas fa-star rating-star"></i>
                    <span class="rating-number">{{ number_format($spa->rating ?? 0, 1) }}</span>
                    <span class="rating-count">({{ $spa->review_count ?? 0 }} reviews)</span>
                </div>
            </div>

            <div class="spa-info-grid">
                <div class="spa-info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $spa->location }}, {{ $spa->city }}</span>
                </div>

                @if($spa->phone)
                    <div class="spa-info-item">
                        <i class="fas fa-phone"></i>
                        <span>{{ $spa->phone }}</span>
                    </div>
                @endif

                @if($spa->email)
                    <div class="spa-info-item">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $spa->email }}</span>
                    </div>
                @endif

                @if($spa->opening_hours)
                    <div class="spa-info-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ $spa->opening_hours }}</span>
                    </div>
                @endif
            </div>

            @if($spa->tags && count($spa->tags) > 0)
                <div class="spa-tags">
                    @foreach($spa->tags as $tag)
                        <span class="spa-tag">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            <hr class="section-divider">

            <p class="section-label">About</p>
            <p class="spa-description-text">{{ $spa->description }}</p>
        </div>
    </div>

    <!-- Services -->
    <div class="services-section">
        <h3>Our Services</h3>

        @if($spa->services && $spa->services->count() > 0)
            <div class="services-grid">
                @foreach($spa->services as $service)
                    <div class="service-card">
                        <div class="service-name">{{ $service->name }}</div>
                        @if($service->description)
                            <div class="service-desc">{{ Str::limit($service->description, 90) }}</div>
                        @endif
                        <div class="service-meta">
                            @if($service->duration_minutes)
                                <div class="service-duration">
                                    <i class="fas fa-clock"></i> {{ $service->duration_minutes }} min
                                </div>
                            @endif
                            @if($service->price)
                                <div class="service-price">${{ number_format($service->price, 0) }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-services">
                <i class="fas fa-spa" style="font-size:36px; margin-bottom:12px; display:block; color:#ddd;"></i>
                No services listed yet.
            </div>
        @endif
    </div>

</div>

@endsection
