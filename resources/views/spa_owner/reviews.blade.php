@extends('layouts.main')

@section('title', 'Customer Reviews - SpaLush')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    .dashboard-container {
        display: flex;
        min-height: 100vh;
        background: #1a1a1a;
        font-family: Arial, sans-serif;
    }

    .main-content {
        flex: 1;
        padding: 40px;
        overflow-y: auto;
    }

    .page-header {
        margin-bottom: 36px;
    }

    .page-header h1 {
        font-size: 30px;
        color: white;
        font-weight: 300;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }

    .page-header p {
        color: rgba(255,255,255,0.45);
        font-size: 14px;
    }

    /* ── Summary bar ── */
    .review-summary {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 36px;
        align-items: center;
        background: #2a2a2a;
        border: 1px solid rgba(201,169,97,0.18);
        border-radius: 12px;
        padding: 30px 36px;
        margin-bottom: 30px;
    }

    .summary-score {
        text-align: center;
    }

    .summary-score .big-num {
        font-size: 56px;
        font-weight: 700;
        color: #c9a961;
        line-height: 1;
        font-family: 'Georgia', serif;
    }

    .summary-score .stars-row {
        color: #c9a961;
        font-size: 18px;
        letter-spacing: 3px;
        margin: 6px 0 4px;
    }

    .summary-score .total-label {
        font-size: 12px;
        color: rgba(255,255,255,0.4);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .bar-chart { width: 100%; }

    .bar-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 13px;
        color: rgba(255,255,255,0.55);
    }

    .bar-row .star-label {
        width: 40px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 4px;
        color: #c9a961;
        font-size: 12px;
    }

    .bar-track {
        flex: 1;
        height: 7px;
        background: rgba(255,255,255,0.08);
        border-radius: 4px;
        overflow: hidden;
    }

    .bar-fill {
        height: 100%;
        background: #c9a961;
        border-radius: 4px;
        transition: width 0.6s ease;
    }

    .bar-count {
        width: 28px;
        text-align: right;
        flex-shrink: 0;
        font-size: 12px;
        color: rgba(255,255,255,0.4);
    }

    /* ── Filter tabs ── */
    .filter-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.55);
        background: #222;
        transition: all 0.2s;
        cursor: pointer;
    }

    .filter-tab:hover { border-color: #c9a961; color: #c9a961; }
    .filter-tab.active { background: #c9a961; border-color: #c9a961; color: #1a1a1a; font-weight: 700; }

    /* ── Review cards ── */
    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .review-card {
        background: #2a2a2a;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 10px;
        padding: 22px 26px;
        transition: border-color 0.2s;
    }

    .review-card:hover { border-color: rgba(201,169,97,0.25); }

    .review-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 12px;
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .reviewer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #c9a961, #8b7644);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .reviewer-name {
        font-size: 14px;
        font-weight: 600;
        color: white;
    }

    .reviewer-meta {
        font-size: 12px;
        color: rgba(255,255,255,0.35);
        margin-top: 2px;
    }

    .review-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
        flex-shrink: 0;
    }

    .review-stars {
        color: #c9a961;
        font-size: 14px;
        letter-spacing: 1px;
    }

    .review-date {
        font-size: 12px;
        color: rgba(255,255,255,0.3);
    }

    .visit-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(201,169,97,0.1);
        border: 1px solid rgba(201,169,97,0.2);
        color: rgba(201,169,97,0.8);
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 12px;
        margin-bottom: 10px;
    }

    .review-comment {
        font-size: 14px;
        color: rgba(255,255,255,0.6);
        line-height: 1.75;
    }

    .no-reviews {
        text-align: center;
        padding: 60px 20px;
        color: rgba(255,255,255,0.3);
        font-size: 15px;
    }

    .no-reviews i {
        font-size: 40px;
        display: block;
        margin-bottom: 14px;
        color: rgba(255,255,255,0.15);
    }

    @media (max-width: 768px) {
        .dashboard-container { flex-direction: column; }
        .main-content { padding: 20px; }
        .review-summary { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <div class="page-header">
            <h1>Customer Reviews</h1>
            <p>See what guests are saying about {{ $spa?->name ?? 'your spa' }}</p>
        </div>

        @if(!$spa)
            <div style="text-align:center;padding:60px 20px;color:rgba(255,255,255,0.4);">
                <i class="fas fa-spa" style="font-size:40px;display:block;margin-bottom:14px;"></i>
                You haven't set up a spa yet.
            </div>
        @else

        {{-- ── Summary ── --}}
        <div class="review-summary">
            <div class="summary-score">
                <div class="big-num">{{ $totalCount > 0 ? number_format($avgRating, 1) : '—' }}</div>
                <div class="stars-row">
                    @for($i = 1; $i <= 5; $i++)
                        {!! $i <= round($avgRating) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>' !!}
                    @endfor
                </div>
                <div class="total-label">{{ $totalCount }} {{ Str::plural('review', $totalCount) }}</div>
            </div>

            <div class="bar-chart">
                @for($star = 5; $star >= 1; $star--)
                    @php $pct = $totalCount > 0 ? round($starCounts[$star] / $totalCount * 100) : 0; @endphp
                    <div class="bar-row">
                        <div class="star-label">{{ $star }} <i class="fas fa-star" style="font-size:10px;"></i></div>
                        <div class="bar-track">
                            <div class="bar-fill" style="width: {{ $pct }}%;"></div>
                        </div>
                        <div class="bar-count">{{ $starCounts[$star] }}</div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- ── Star filter tabs ── --}}
        @php $filterStar = request()->query('star'); @endphp
        <div class="filter-tabs">
            <a href="{{ request()->url() }}" class="filter-tab {{ !$filterStar ? 'active' : '' }}">
                All ({{ $totalCount }})
            </a>
            @for($s = 5; $s >= 1; $s--)
                <a href="{{ request()->url() }}?star={{ $s }}"
                   class="filter-tab {{ $filterStar == $s ? 'active' : '' }}">
                    {{ $s }} <i class="fas fa-star" style="font-size:11px;color:{{ $filterStar == $s ? '#1a1a1a' : '#c9a961' }};"></i>
                    ({{ $starCounts[$s] }})
                </a>
            @endfor
        </div>

        {{-- ── Review list ── --}}
        @php
            $displayedReviews = $filterStar
                ? $reviews->where('rating', (int) $filterStar)
                : $reviews;
        @endphp

        @if($displayedReviews->count() > 0)
            <div class="reviews-list">
                @foreach($displayedReviews as $review)
                    <div class="review-card">
                        <div class="review-card-top">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    {{ strtoupper(substr($review->customer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="reviewer-name">{{ $review->customer->name }}</div>
                                    <div class="reviewer-meta">{{ $review->customer->email }}</div>
                                </div>
                            </div>
                            <div class="review-right">
                                <div class="review-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        {!! $i <= $review->rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>' !!}
                                    @endfor
                                </div>
                                <div class="review-date">{{ $review->created_at->format('d M Y') }}</div>
                            </div>
                        </div>

                        @if($review->booking)
                            <div class="visit-badge">
                                <i class="fas fa-calendar-check"></i>
                                Visit on {{ \Carbon\Carbon::parse($review->booking->booking_date)->format('d M Y') }}
                                &nbsp;·&nbsp; Rs. {{ number_format($review->booking->total_price, 0) }}
                            </div>
                        @endif

                        @if($review->comment)
                            <p class="review-comment">{{ $review->comment }}</p>
                        @else
                            <p class="review-comment" style="color:rgba(255,255,255,0.25);font-style:italic;">No written comment.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-reviews">
                <i class="fas fa-comment-slash"></i>
                No {{ $filterStar ? $filterStar . '-star' : '' }} reviews yet.
            </div>
        @endif

        @endif
    </div>
</div>

@endsection
