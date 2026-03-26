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
        background: rgba(201,169,97,0.12);
        color: #c9a961;
        border-left: 4px solid #c9a961;
    }

    .status-banner.approved {
        background: rgba(67,160,71,0.12);
        color: #6fcf72;
        border-left: 4px solid #43a047;
    }

    .status-banner.disapproved {
        background: rgba(229,57,53,0.12);
        color: #ef9a9a;
        border-left: 4px solid #e53935;
    }

    /* Main card */
    .spa-card-main {
        background: #2a2a2a;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.4);
        overflow: hidden;
        margin-bottom: 35px;
        border: 1px solid rgba(201,169,97,0.15);
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
        background: #1a1a1a;
        color: #c9a961;
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
        color: white;
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
    .rating-number { font-weight: 700; font-size: 18px; color: white; }
    .rating-count { color: rgba(255,255,255,0.5); font-size: 14px; }

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
        color: rgba(255,255,255,0.6);
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
        background: rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.6);
        padding: 5px 14px;
        border-radius: 14px;
        font-size: 13px;
    }

    .section-divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.1);
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
        color: rgba(255,255,255,0.6);
        font-size: 15px;
        line-height: 1.8;
    }

    /* Services */
    .services-section {
        background: #2a2a2a;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.4);
        padding: 35px 40px;
        margin-bottom: 35px;
        border: 1px solid rgba(201,169,97,0.15);
    }

    .services-section h3 {
        font-size: 22px;
        font-weight: 300;
        color: white;
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
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s;
        background: #333;
        display: flex;
        flex-direction: column;
    }

    .service-card:hover {
        border-color: #c9a961;
        box-shadow: 0 4px 12px rgba(201,169,97,0.15);
    }

    .service-card.selected {
        border-color: #c9a961;
        box-shadow: 0 0 0 2px rgba(201,169,97,0.4);
    }

    .service-img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        display: block;
    }

    .service-img-placeholder {
        width: 100%;
        height: 150px;
        background: linear-gradient(135deg, #3a3a3a 0%, #2a2a2a 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.2);
        font-size: 36px;
    }

    .service-body {
        padding: 18px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .service-name {
        font-size: 16px;
        font-weight: 600;
        color: white;
        margin-bottom: 6px;
    }

    .service-desc {
        font-size: 13px;
        color: rgba(255,255,255,0.5);
        line-height: 1.6;
        margin-bottom: 14px;
        flex: 1;
    }

    .service-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        margin-bottom: 12px;
    }

    .service-duration {
        color: rgba(255,255,255,0.5);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .service-price {
        font-weight: 700;
        color: #c9a961;
        font-size: 15px;
    }

    .service-select-btn {
        width: 100%;
        padding: 8px;
        border: 1px solid rgba(201,169,97,0.4);
        border-radius: 5px;
        background: transparent;
        color: #c9a961;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        letter-spacing: 0.5px;
    }

    .service-select-btn:hover,
    .service-card.selected .service-select-btn {
        background: #c9a961;
        color: #1a1a1a;
    }

    .no-services {
        text-align: center;
        padding: 40px 20px;
        color: #bbb;
        font-size: 15px;
    }

    /* Book Now floating bar */
    .book-bar {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: #1a1a1a;
        border-top: 1px solid rgba(201,169,97,0.3);
        padding: 14px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 900;
        gap: 20px;
        transition: transform 0.3s;
        transform: translateY(100%);
    }

    .book-bar.visible { transform: translateY(0); }

    .book-bar-info {
        color: rgba(255,255,255,0.7);
        font-size: 14px;
    }

    .book-bar-info strong {
        color: #c9a961;
        font-size: 16px;
    }

    .book-bar-btn {
        padding: 12px 32px;
        background: #c9a961;
        color: #1a1a1a;
        border: none;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        letter-spacing: 0.5px;
        transition: background 0.2s;
        white-space: nowrap;
    }

    .book-bar-btn:hover { background: #b8985a; }

    /* Booking Modal */
    .booking-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.75);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .booking-overlay.open { display: flex; }

    .booking-modal {
        background: #2a2a2a;
        border-radius: 12px;
        border: 1px solid rgba(201,169,97,0.25);
        width: 100%;
        max-width: 560px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 36px 40px;
        position: relative;
    }

    .booking-modal h2 {
        font-size: 22px;
        font-weight: 300;
        color: white;
        font-family: 'Georgia', serif;
        margin-bottom: 6px;
    }

    .booking-modal .modal-subtitle {
        color: rgba(255,255,255,0.5);
        font-size: 14px;
        margin-bottom: 28px;
    }

    .modal-close {
        position: absolute;
        top: 16px; right: 20px;
        background: none;
        border: none;
        color: rgba(255,255,255,0.5);
        font-size: 22px;
        cursor: pointer;
        line-height: 1;
    }

    .modal-close:hover { color: white; }

    .modal-section-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #c9a961;
        margin-bottom: 10px;
        margin-top: 20px;
    }

    .selected-services-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 6px;
    }

    .selected-service-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 14px;
        background: rgba(255,255,255,0.05);
        border-radius: 6px;
        font-size: 14px;
        color: rgba(255,255,255,0.85);
    }

    .selected-service-row span { color: #c9a961; font-weight: 600; }

    .modal-total {
        display: flex;
        justify-content: space-between;
        padding: 12px 14px;
        background: rgba(201,169,97,0.08);
        border: 1px solid rgba(201,169,97,0.2);
        border-radius: 6px;
        font-size: 15px;
        font-weight: 600;
        color: white;
        margin-bottom: 6px;
    }

    .modal-total span { color: #c9a961; }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: rgba(255,255,255,0.6);
        margin-bottom: 7px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 11px 14px;
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 6px;
        color: white;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #c9a961;
    }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    .payment-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 18px;
    }

    .payment-opt {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .payment-opt input[type=radio] { display: none; }

    .payment-opt.selected,
    .payment-opt:has(input:checked) {
        border-color: #c9a961;
        background: rgba(201,169,97,0.08);
    }

    .payment-opt i { font-size: 20px; flex-shrink: 0; }

    .pay-opt-title { font-size: 14px; font-weight: 700; color: white; }
    .pay-opt-sub   { font-size: 11px; color: rgba(255,255,255,0.45); margin-top: 2px; }

    .btn-submit-booking {
        width: 100%;
        padding: 14px;
        background: #c9a961;
        color: #1a1a1a;
        border: none;
        border-radius: 7px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        letter-spacing: 0.5px;
        margin-top: 8px;
        transition: background 0.2s;
    }

    .btn-submit-booking:hover { background: #b8985a; }

    .alert-success {
        background: rgba(67,160,71,0.12);
        color: #6fcf72;
        border: 1px solid rgba(67,160,71,0.3);
        border-radius: 6px;
        padding: 12px 18px;
        margin-bottom: 22px;
        font-size: 14px;
    }

    .alert-error {
        background: rgba(229,57,53,0.12);
        color: #ef9a9a;
        border: 1px solid rgba(229,57,53,0.3);
        border-radius: 6px;
        padding: 12px 18px;
        margin-bottom: 14px;
        font-size: 14px;
    }

    /* ── Category Filter Bar ── */
    .cat-filter-bar {
        display: flex; flex-wrap: wrap; gap: 10px;
        margin-bottom: 28px; align-items: center;
    }
    .cat-filter-label {
        font-size: 11px; color: rgba(255,255,255,0.4);
        text-transform: uppercase; letter-spacing: 1px; margin-right: 4px;
    }
    .cat-btn {
        padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 500;
        text-decoration: none; border: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.6); background: #222; transition: all 0.2s; cursor: pointer;
    }
    .cat-btn:hover { border-color: #c9a961; color: #c9a961; background: rgba(201,169,97,0.08); }
    .cat-btn.active { background: #c9a961; border-color: #c9a961; color: #1a1a1a; font-weight: 700; }

    .cat-section-heading {
        font-size: 14px; font-weight: 600; color: #c9a961;
        text-transform: uppercase; letter-spacing: 1px;
        margin-bottom: 14px; margin-top: 8px;
        padding-bottom: 8px; border-bottom: 1px solid rgba(201,169,97,0.2);
    }
    .cat-section { margin-bottom: 30px; }

    /* Owner actions */
    .owner-actions {
        background: rgba(201,169,97,0.08);
        border: 1px solid rgba(201,169,97,0.25);
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
        color: rgba(201,169,97,0.8);
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
            @php
                $activeCategory = request()->query('cat');
                $allCategories = $spa->services
                    ->filter(fn($s) => $s->spaCategory)
                    ->pluck('spaCategory')
                    ->unique('id')
                    ->sortBy('name');

                $filtered = $activeCategory
                    ? $spa->services->filter(fn($s) => optional($s->spaCategory)->id == $activeCategory)
                    : $spa->services;

                $grouped = $activeCategory
                    ? collect(['Services' => $filtered])
                    : $filtered->groupBy(fn($s) => $s->spaCategory?->name ?? 'Uncategorized');

                $isCustomer = auth()->check() && auth()->user()->role === 'customer';
                $isApproved = $spa->status === 'approved';
            @endphp

            {{-- Filter Bar --}}
            @if($allCategories->count() > 1)
            <div class="cat-filter-bar">
                <span class="cat-filter-label">Filter:</span>
                <a href="{{ request()->url() }}"
                   class="cat-btn {{ !$activeCategory ? 'active' : '' }}">All</a>
                @foreach($allCategories as $cat)
                    <a href="{{ request()->url() }}?cat={{ $cat->id }}"
                       class="cat-btn {{ $activeCategory == $cat->id ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
            @endif

            @if($isCustomer && $isApproved)
                <p style="font-size:13px;color:rgba(255,255,255,0.45);margin-bottom:20px;">
                    <i class="fas fa-hand-pointer"></i> Select services you'd like to book, then click <strong style="color:#c9a961;">Book Now</strong>.
                </p>
            @endif

            {{-- Grouped Services --}}
            @foreach($grouped as $catName => $services)
                @if(!$activeCategory && $grouped->count() > 1)
                    <div class="cat-section-heading">{{ $catName }}</div>
                @endif
                <div class="services-grid {{ !$loop->last ? 'cat-section' : '' }}">
                    @foreach($services as $service)
                        <div class="service-card {{ $isCustomer && $isApproved ? 'bookable' : '' }}"
                             data-id="{{ $service->id }}"
                             data-name="{{ $service->name }}"
                             data-price="{{ $service->price ?? 0 }}"
                             data-duration="{{ $service->duration_minutes ?? 0 }}"
                             onclick="{{ $isCustomer && $isApproved ? 'toggleService(this)' : '' }}">

                            {{-- Image --}}
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="service-img">
                            @else
                                <div class="service-img-placeholder"><i class="fas fa-spa"></i></div>
                            @endif

                            <div class="service-body">
                                <div class="service-name">{{ $service->name }}</div>
                                @if($service->description)
                                    <div class="service-desc">{{ Str::limit($service->description, 90) }}</div>
                                @endif
                                <div class="service-meta">
                                    @if($service->duration_minutes)
                                        <div class="service-duration">
                                            <i class="fas fa-clock"></i> {{ $service->duration_minutes }} min
                                        </div>
                                    @else
                                        <span></span>
                                    @endif
                                    @if($service->price)
                                        <div class="service-price">Rs. {{ number_format($service->price, 0) }}</div>
                                    @endif
                                </div>
                                @if($isCustomer && $isApproved)
                                    <button class="service-select-btn" type="button">
                                        <i class="fas fa-plus"></i> Add to Booking
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

        @else
            <div class="no-services">
                <i class="fas fa-spa" style="font-size:36px; margin-bottom:12px; display:block; color:#ddd;"></i>
                No services listed yet.
            </div>
        @endif
    </div>

</div>

{{-- Floating Book Bar (customers only) --}}
@auth
    @if(auth()->user()->role === 'customer' && $spa->status === 'approved')
        <div class="book-bar" id="bookBar">
            <div class="book-bar-info">
                <div><span id="barCount">0</span> service(s) selected &nbsp;·&nbsp; <strong id="barTotal">Rs. 0</strong> &nbsp;·&nbsp; <span id="barDuration">0 min</span></div>
            </div>
            <button class="book-bar-btn" onclick="openModal()">
                <i class="fas fa-calendar-check"></i> Book Now
            </button>
        </div>

        {{-- Booking Modal --}}
        <div class="booking-overlay" id="bookingOverlay">
            <div class="booking-modal">
                <button class="modal-close" onclick="closeModal()">&times;</button>
                <h2>Book Your Experience</h2>
                <p class="modal-subtitle">at {{ $spa->name }}</p>

                @if(session('success'))
                    <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert-error">
                        <div style="font-weight:700;margin-bottom:6px;font-size:13px;">
                            <i class="fas fa-exclamation-circle"></i> Could not complete booking:
                        </div>
                        @foreach($errors->all() as $e)
                            <div style="margin-top:4px;">&#8226; {{ $e }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('bookings.store', $spa) }}" id="bookingForm">
                    @csrf

                    {{-- Hidden service ids --}}
                    <div id="serviceInputs"></div>

                    <div class="modal-section-title">Selected Services</div>
                    <div class="selected-services-list" id="modalServiceList"></div>
                    <div class="modal-total">
                        <span>Total</span>
                        <span id="modalTotal">Rs. 0 &nbsp;·&nbsp; 0 min</span>
                    </div>

                    <div class="modal-section-title">Your Details</div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" placeholder="+977-98XXXXXXXX"
                               value="{{ old('phone') }}" required>
                    </div>

                    <div class="modal-section-title">Appointment</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="booking_date"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('booking_date') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" name="booking_time"
                                   value="{{ old('booking_time') }}" required>
                        </div>
                    </div>

                    <div class="modal-section-title">Payment Option</div>
                    <div class="payment-options">
                        <label class="payment-opt {{ old('payment_option', 'pay_later') === 'pay_now' ? 'selected' : '' }}">
                            <input type="radio" name="payment_option" value="pay_now"
                                   {{ old('payment_option', 'pay_later') === 'pay_now' ? 'checked' : '' }}
                                   onchange="updatePayBtn(this)">
                            <i class="fas fa-credit-card" style="color:#c9a961;"></i>
                            <div>
                                <div class="pay-opt-title">Pay Now</div>
                                <div class="pay-opt-sub">Pay online while booking</div>
                            </div>
                        </label>
                        <label class="payment-opt {{ old('payment_option', 'pay_later') === 'pay_later' ? 'selected' : '' }}">
                            <input type="radio" name="payment_option" value="pay_later"
                                   {{ old('payment_option', 'pay_later') === 'pay_later' ? 'checked' : '' }}
                                   onchange="updatePayBtn(this)">
                            <i class="fas fa-hand-holding-usd" style="color:#c9a961;"></i>
                            <div>
                                <div class="pay-opt-title">Pay Later</div>
                                <div class="pay-opt-sub">Pay at the spa after service</div>
                            </div>
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Special Notes (optional)</label>
                        <textarea name="notes" rows="3" placeholder="Any preferences or special requests...">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn-submit-booking" id="submitBookingBtn">
                        <i class="fas fa-calendar-check"></i> <span id="submitBtnText">Confirm &amp; Pay Later</span>
                    </button>
                </form>
            </div>
        </div>

        <script>
            const selected = {};

            function toggleService(card) {
                const id       = card.dataset.id;
                const name     = card.dataset.name;
                const price    = parseFloat(card.dataset.price) || 0;
                const duration = parseInt(card.dataset.duration) || 0;
                const btn      = card.querySelector('.service-select-btn');

                if (selected[id]) {
                    delete selected[id];
                    card.classList.remove('selected');
                    btn.innerHTML = '<i class="fas fa-plus"></i> Add to Booking';
                } else {
                    selected[id] = { name, price, duration };
                    card.classList.add('selected');
                    btn.innerHTML = '<i class="fas fa-check"></i> Selected';
                }
                updateBar();
            }

            function updateBar() {
                const ids = Object.keys(selected);
                const total    = ids.reduce((s, id) => s + selected[id].price, 0);
                const duration = ids.reduce((s, id) => s + selected[id].duration, 0);

                document.getElementById('barCount').textContent    = ids.length;
                document.getElementById('barTotal').textContent    = 'Rs. ' + total.toLocaleString();
                document.getElementById('barDuration').textContent = duration + ' min';

                const bar = document.getElementById('bookBar');
                ids.length > 0 ? bar.classList.add('visible') : bar.classList.remove('visible');
            }

            function openModal() {
                const ids = Object.keys(selected);
                if (ids.length === 0) return;

                // Populate modal service list
                const list = document.getElementById('modalServiceList');
                const inputs = document.getElementById('serviceInputs');
                list.innerHTML = '';
                inputs.innerHTML = '';

                let total = 0, duration = 0;
                ids.forEach(id => {
                    const s = selected[id];
                    total    += s.price;
                    duration += s.duration;

                    const row = document.createElement('div');
                    row.className = 'selected-service-row';
                    row.innerHTML = `<div>${s.name} <small style="color:rgba(255,255,255,0.4)">${s.duration} min</small></div><span>Rs. ${s.price.toLocaleString()}</span>`;
                    list.appendChild(row);

                    const inp = document.createElement('input');
                    inp.type  = 'hidden';
                    inp.name  = 'services[]';
                    inp.value = id;
                    inputs.appendChild(inp);
                });

                document.getElementById('modalTotal').innerHTML =
                    'Rs. ' + total.toLocaleString() + ' &nbsp;·&nbsp; ' + duration + ' min';

                document.getElementById('bookingOverlay').classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                document.getElementById('bookingOverlay').classList.remove('open');
                document.body.style.overflow = '';
            }

            // Close on overlay click
            document.getElementById('bookingOverlay').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });

            function updatePayBtn(radio) {
                document.querySelectorAll('.payment-opt').forEach(el => el.classList.remove('selected'));
                radio.closest('.payment-opt').classList.add('selected');
                const txt = document.getElementById('submitBtnText');
                txt.textContent = radio.value === 'pay_now' ? 'Confirm & Pay Now' : 'Confirm & Pay Later';
            }

            // Init button label on page load
            document.addEventListener('DOMContentLoaded', function() {
                const checked = document.querySelector('input[name="payment_option"]:checked');
                if (checked) updatePayBtn(checked);
            });

            // If there are validation errors, re-open modal
            @if($errors->any())
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('bookingOverlay').classList.add('open');
                    document.body.style.overflow = 'hidden';
                });
            @endif
        </script>
    @endif
@endauth

@endsection
