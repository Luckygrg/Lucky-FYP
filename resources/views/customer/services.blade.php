@extends('layouts.main')

@section('title', 'Browse Services - SpaLush')

@section('content')

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { background: #1a1a1a; }

    .page-wrapper { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }

    /* ── Header ── */
    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        color: #c9a961; text-decoration: none; font-size: 14px; margin-bottom: 22px;
    }
    .back-link:hover { color: #b8985a; }

    .page-header { margin-bottom: 28px; }
    .page-header h1 {
        font-size: 32px; color: white; font-weight: 300;
        font-family: 'Georgia', serif; letter-spacing: 1px; margin-bottom: 6px;
    }
    .page-header p { color: rgba(255,255,255,0.5); font-size: 15px; }

    /* ── Stats Row ── */
    .stats-row { display: flex; gap: 14px; margin-bottom: 32px; flex-wrap: wrap; }
    .stat-pill {
        background: #2a2a2a; border-radius: 8px;
        padding: 14px 22px; border-left: 4px solid #c9a961; min-width: 140px;
    }
    .stat-pill .label { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 4px; }
    .stat-pill .value { font-size: 24px; font-weight: 300; color: #c9a961; font-family: 'Georgia', serif; }

    /* ── Category Filter Bar ── */
    .filter-bar {
        display: flex; flex-wrap: wrap; gap: 10px;
        margin-bottom: 36px; align-items: center;
    }
    .filter-label {
        font-size: 12px; color: rgba(255,255,255,0.4);
        text-transform: uppercase; letter-spacing: 1px; margin-right: 6px; align-self: center;
    }
    .filter-btn {
        padding: 8px 18px; border-radius: 20px; font-size: 13px; font-weight: 500;
        text-decoration: none; border: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.6); background: #2a2a2a; transition: all 0.2s;
    }
    .filter-btn:hover { border-color: #c9a961; color: #c9a961; background: rgba(201,169,97,0.08); }
    .filter-btn.active { background: #c9a961; border-color: #c9a961; color: #1a1a1a; font-weight: 700; }

    /* ── Section Heading ── */
    .section-heading {
        font-size: 20px; color: white; font-weight: 300;
        font-family: 'Georgia', serif; margin-bottom: 20px;
        padding-bottom: 10px; border-bottom: 1px solid rgba(201,169,97,0.2);
        display: flex; align-items: center; gap: 10px;
    }
    .section-heading .count {
        font-size: 13px; color: #c9a961; background: rgba(201,169,97,0.15);
        border: 1px solid rgba(201,169,97,0.3); padding: 2px 10px; border-radius: 12px;
        font-family: Arial, sans-serif; font-weight: 600;
    }

    /* ── Services Grid ── */
    .services-section { margin-bottom: 48px; }
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
        gap: 20px;
    }

    .service-card {
        background: #2a2a2a; border-radius: 10px; overflow: hidden;
        border: 1px solid rgba(255,255,255,0.07);
        transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    }
    .service-card:hover {
        transform: translateY(-4px); box-shadow: 0 10px 24px rgba(0,0,0,0.5);
        border-color: rgba(201,169,97,0.35);
    }

    .service-img-wrap {
        height: 170px; overflow: hidden; background: #333;
        display: flex; align-items: center; justify-content: center;
    }
    .service-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .service-img-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        font-size: 52px; color: #555;
        background: linear-gradient(135deg, #2a2a2a, #333);
    }

    .service-body { padding: 18px; }
    .service-title { font-size: 15px; font-weight: 600; color: white; margin-bottom: 6px; }
    .service-desc {
        font-size: 13px; color: rgba(255,255,255,0.5);
        line-height: 1.55; margin-bottom: 14px; min-height: 40px;
    }

    .service-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 14px; }
    .tag {
        padding: 3px 10px; border-radius: 10px; font-size: 11px; font-weight: 500;
        background: rgba(201,169,97,0.12); color: #c9a961;
        border: 1px solid rgba(201,169,97,0.25);
    }
    .tag.duration {
        background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.55);
        border-color: rgba(255,255,255,0.1);
    }

    .service-footer {
        display: flex; justify-content: space-between; align-items: center;
        border-top: 1px solid rgba(255,255,255,0.07); padding-top: 12px;
    }
    .service-price { font-size: 17px; font-weight: 700; color: #c9a961; }
    .service-available { font-size: 12px; color: #5cb85c; }

    /* ── Empty State ── */
    .empty-state {
        background: #2a2a2a; border-radius: 10px; padding: 70px 20px;
        text-align: center; color: rgba(255,255,255,0.35);
        border: 1px solid rgba(255,255,255,0.06);
    }
    .empty-state .icon { font-size: 50px; margin-bottom: 14px; }
    .empty-state p { font-size: 16px; }

    @media (max-width: 640px) {
        .services-grid { grid-template-columns: 1fr; }
        .page-header h1 { font-size: 24px; }
    }
</style>

<div class="page-wrapper">

    <a href="{{ route('customer.dashboard') }}" class="back-link">← Back to Dashboard</a>

    <div class="page-header">
        <h1>Browse Services</h1>
        <p>Filter by category to find the treatment you're looking for.</p>
    </div>

    <div class="stats-row">
        <div class="stat-pill">
            <div class="label">Total Services</div>
            <div class="value">{{ $totalServices }}</div>
        </div>
        <div class="stat-pill">
            <div class="label">Categories</div>
            <div class="value">{{ $categories->count() }}</div>
        </div>
    </div>

    {{-- ── Category Filter Bar ── --}}
    <div class="filter-bar">
        <span class="filter-label">Filter by:</span>
        <a href="{{ route('customer.services') }}"
           class="filter-btn {{ !$selectedCategory ? 'active' : '' }}">
            All Services
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('customer.services', ['category' => $cat->id]) }}"
               class="filter-btn {{ $selectedCategory == $cat->id ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    {{-- ── Services ── --}}
    @if($services->isEmpty())
        <div class="empty-state">
            <div class="icon">🌿</div>
            <p>No services found{{ $selectedCategory ? ' in this category' : '' }}. Please check back soon.</p>
        </div>
    @else
        @php
            $grouped = $selectedCategory
                ? collect(['Services' => $services])
                : $services->groupBy(fn($s) => $s->spaCategory?->name ?? 'Uncategorized');
        @endphp

        @foreach($grouped as $categoryName => $items)
        <div class="services-section">
            @if(!$selectedCategory)
            <div class="section-heading">
                {{ $categoryName }}
                <span class="count">{{ $items->count() }} {{ Str::plural('service', $items->count()) }}</span>
            </div>
            @endif

            <div class="services-grid">
                @foreach($items as $service)
                <div class="service-card">
                    <div class="service-img-wrap">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}">
                        @else
                            <div class="service-img-placeholder">🌿</div>
                        @endif
                    </div>
                    <div class="service-body">
                        <div class="service-title">{{ $service->name }}</div>
                        @if($service->description)
                            <div class="service-desc">{{ Str::limit($service->description, 90) }}</div>
                        @else
                            <div class="service-desc"></div>
                        @endif

                        <div class="service-tags">
                            @if($service->spaCategory)
                                <span class="tag">{{ $service->spaCategory->name }}</span>
                            @endif
                            @if($service->duration_minutes)
                                <span class="tag duration">⏱ {{ $service->duration_minutes }} min</span>
                            @endif
                        </div>

                        <div class="service-footer">
                            <span class="service-price">
                                @if($service->price)
                                    Rs. {{ number_format($service->price, 2) }}
                                @else
                                    Price on request
                                @endif
                            </span>
                            <span class="service-available">✓ Available</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    @endif

</div>

@endsection

    .page-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .page-header {
        margin-bottom: 36px;
    }
    .page-header h1 {
        font-size: 32px;
        color: white;
        font-weight: 300;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }
    .page-header p { color: rgba(255,255,255,0.55); font-size: 15px; }

    /* ── Summary Bar ── */
    .summary-bar { display: flex; gap: 16px; margin-bottom: 32px; flex-wrap: wrap; }
    .summary-pill {
        background: #2a2a2a;
        border-radius: 8px;
        padding: 16px 24px;
        border-left: 4px solid #c9a961;
        min-width: 150px;
    }
    .summary-pill .label { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 5px; }
    .summary-pill .value { font-size: 26px; font-weight: 300; color: #c9a961; font-family: 'Georgia', serif; }

    /* ── Spa Block ── */
    .spa-block {
        background: #2a2a2a;
        border-radius: 10px;
        margin-bottom: 28px;
        overflow: hidden;
        border: 1px solid rgba(201,169,97,0.15);
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .spa-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        background: linear-gradient(135deg, #1e1e1e 0%, #2d2d2d 100%);
        flex-wrap: wrap;
        gap: 12px;
    }
    .spa-header-left { display: flex; align-items: center; gap: 14px; }
    .spa-avatar {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, #c9a961, #b8985a);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 20px; font-weight: 700; flex-shrink: 0;
    }
    .spa-name { font-size: 17px; font-weight: 500; color: white; }
    .spa-meta {
        font-size: 12px; color: rgba(255,255,255,0.5);
        margin-top: 3px; display: flex; gap: 12px; flex-wrap: wrap;
    }
    .spa-meta span::before { content: '• '; }
    .spa-meta span:first-child::before { content: ''; }

    .service-count-badge {
        background: rgba(201,169,97,0.2);
        color: #c9a961;
        border: 1px solid rgba(201,169,97,0.4);
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        flex-shrink: 0;
    }

    /* ── Services Grid ── */
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        padding: 24px;
    }

    .service-card {
        background: #1e1e1e;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.07);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .service-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        border-color: rgba(201,169,97,0.3);
    }

    .service-img-wrap {
        height: 160px;
        overflow: hidden;
        background: #2d2d2d;
        display: flex; align-items: center; justify-content: center;
    }
    .service-img-wrap img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .service-img-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        font-size: 48px; color: #444;
    }

    .service-body { padding: 16px; }
    .service-title {
        font-size: 15px; font-weight: 600; color: white;
        margin-bottom: 6px;
    }
    .service-desc {
        font-size: 13px; color: rgba(255,255,255,0.5);
        line-height: 1.5; margin-bottom: 12px;
        min-height: 38px;
    }

    .service-meta {
        display: flex; flex-wrap: wrap; gap: 8px;
        align-items: center; margin-bottom: 10px;
    }
    .meta-chip {
        background: rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.6);
        padding: 3px 10px; border-radius: 10px; font-size: 12px;
    }
    .meta-chip.category {
        background: rgba(201,169,97,0.15);
        color: #c9a961;
    }

    .service-footer {
        display: flex; justify-content: space-between; align-items: center;
        border-top: 1px solid rgba(255,255,255,0.07);
        padding-top: 10px; margin-top: 4px;
    }
    .service-price {
        font-size: 16px; font-weight: 600; color: #c9a961;
    }
    .service-duration {
        font-size: 12px; color: rgba(255,255,255,0.4);
    }

    /* Empty / No Services */
    .no-services-row {
        padding: 28px 24px;
        text-align: center;
        color: rgba(255,255,255,0.4);
        font-size: 14px;
    }

    .empty-state {
        background: #2a2a2a;
        border-radius: 10px;
        padding: 70px 20px;
        text-align: center;
        color: rgba(255,255,255,0.35);
    }
    .empty-state .icon { font-size: 50px; margin-bottom: 14px; }
    .empty-state p { font-size: 16px; }

    /* Back link */
    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        color: #c9a961; text-decoration: none; font-size: 14px; margin-bottom: 22px;
    }
    .back-link:hover { color: #b8985a; }

    @media (max-width: 640px) {
        .services-grid { grid-template-columns: 1fr; padding: 16px; }
        .page-header h1 { font-size: 24px; }
    }
</style>

<div class="page-wrapper">

    <a href="{{ route('customer.dashboard') }}" class="back-link">← Back to Dashboard</a>

    <div class="page-header">
        <h1>Browse Services</h1>
        <p>Discover available treatments and services from our approved spas.</p>
    </div>

    @php
        $totalServices = $spas->sum(fn($s) => $s->services->count());
    @endphp

    <div class="summary-bar">
        <div class="summary-pill">
            <div class="label">Spas Available</div>
            <div class="value">{{ $spas->count() }}</div>
        </div>
        <div class="summary-pill">
            <div class="label">Services Available</div>
            <div class="value">{{ $totalServices }}</div>
        </div>
    </div>

    @if($spas->isEmpty())
        <div class="empty-state">
            <div class="icon">🛁</div>
            <p>No spa services are available at the moment. Please check back soon.</p>
        </div>
    @else
        @foreach($spas as $spa)
        <div class="spa-block">
            <div class="spa-header">
                <div class="spa-header-left">
                    <div class="spa-avatar">{{ strtoupper(substr($spa->name, 0, 1)) }}</div>
                    <div>
                        <div class="spa-name">{{ $spa->name }}</div>
                        <div class="spa-meta">
                            <span>{{ $spa->city }}</span>
                            @if($spa->location)<span>{{ $spa->location }}</span>@endif
                            @if($spa->price_range)<span>{{ $spa->price_range }}</span>@endif
                            @if($spa->opening_hours)<span>{{ $spa->opening_hours }}</span>@endif
                        </div>
                    </div>
                </div>
                <span class="service-count-badge">
                    {{ $spa->services->count() }} {{ Str::plural('Service', $spa->services->count()) }}
                </span>
            </div>

            @if($spa->services->isEmpty())
                <div class="no-services-row">
                    No available services at this spa right now.
                </div>
            @else
                <div class="services-grid">
                    @foreach($spa->services as $service)
                    <div class="service-card">
                        <div class="service-img-wrap">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}">
                            @else
                                <div class="service-img-placeholder">🌿</div>
                            @endif
                        </div>
                        <div class="service-body">
                            <div class="service-title">{{ $service->name }}</div>
                            @if($service->description)
                                <div class="service-desc">{{ Str::limit($service->description, 90) }}</div>
                            @else
                                <div class="service-desc"></div>
                            @endif
                            <div class="service-meta">
                                @if($service->spaCategory)
                                    <span class="meta-chip category">{{ $service->spaCategory->name }}</span>
                                @endif
                                @if($service->duration_minutes)
                                    <span class="meta-chip">⏱ {{ $service->duration_minutes }} min</span>
                                @endif
                            </div>
                            <div class="service-footer">
                                <span class="service-price">
                                    @if($service->price)
                                        Rs. {{ number_format($service->price, 2) }}
                                    @else
                                        Price on request
                                    @endif
                                </span>
                                <span class="service-duration" style="color: #5cb85c; font-size: 12px;">✓ Available</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endforeach
    @endif

</div>

@endsection
