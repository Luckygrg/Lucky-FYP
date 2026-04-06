@extends('layouts.main')

@section('title', 'Our Spas - SpaLush')

@section('content')

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    .spas-hero {
        background: linear-gradient(rgba(0,0,0,0.40), rgba(0,0,0,0.40)), 
        url('{{ asset('assets/img/OurSpa.jpg') }}') center/cover;
        padding: 100px 20px;
        text-align: center;
        color: #FAF7F2;
    }
    
    .spas-hero h1 {
        font-size: 56px;
        font-weight: 300;
        letter-spacing: 3px;
        margin-bottom: 32px;
        font-family: 'Georgia', serif;
        text-transform: uppercase;
        line-height: 1.08;
    }
    .spas-hero h1 em {
        font-style: normal;
    }
    .spas-hero p {
        font-size: 20px;
        font-weight: 300;
        color: #fff;
        margin-bottom: 36px;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
        letter-spacing: 1px;

    }
    
    .spas-hero p {
        font-size: 18px;
        font-weight: 300;
    }
    
    .spas-container {
        max-width: 1400px;
        margin: 60px auto;
        padding: 0 40px;
    }
    
    .spas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
    }
    
    .spa-card {
        background: #FFFFFF;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        position: relative;
    }
    
    .spa-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }
    
    .spa-image {
        width: 100%;
        height: 250px;
        background: linear-gradient(135deg, #C8916A 0%, #895D3E 100%);
        position: relative;
        overflow: hidden;
    }
    
    .spa-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .price-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #FAF7F2;
        color: #C8916A;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .favorite-btn {
        position: absolute;
        bottom: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        background: rgba(250,247,242,0.8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .favorite-btn:hover {
        background: #C8916A;
        color: #1C1008;
    }
    
    .spa-content {
        padding: 25px;
    }
    
    .spa-tags {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }
    
    .spa-tag {
        font-size: 12px;
        color: rgba(28,16,8,0.6);
        background: rgba(28,16,8,0.08);
        padding: 4px 12px;
        border-radius: 12px;
    }
    
    .spa-name {
        font-size: 22px;
        font-weight: 600;
        color: #1C1008;
        margin-bottom: 8px;
        font-family: 'Georgia', serif;
    }
    
    .spa-location {
        display: flex;
        align-items: center;
        gap: 6px;
        color: rgba(28,16,8,0.6);
        font-size: 14px;
        margin-bottom: 12px;
    }
    
    .spa-description {
        color: rgba(28,16,8,0.6);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .spa-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid rgba(28,16,8,0.08);
    }
    
    .spa-rating {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .rating-star {
        color: #C8916A;
        font-size: 16px;
    }
    
    .rating-number {
        font-weight: 600;
        color: #1C1008;
        font-size: 15px;
    }
    
    .rating-count {
        color: rgba(28,16,8,0.5);
        font-size: 13px;
    }
    
    .book-btn {
        padding: 10px 24px;
        background: #FAF7F2;
        color: #1C1008;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .book-btn:hover {
        background: #C8916A;
    }
    
    .no-spas {
        text-align: center;
        padding: 80px 20px;
        color: rgba(28,16,8,0.6);
    }
    
    .no-spas h2 {
        font-size: 28px;
        font-weight: 300;
        margin-bottom: 15px;
        font-family: 'Georgia', serif;
    }
    
    @media (max-width: 768px) {
        .spas-grid {
            grid-template-columns: 1fr;
        }
        
        .spas-hero h1 {
            font-size: 32px;
        }
    }

    .explore-btn {
        display: inline-block;
        padding: 16px 50px;
        background: transparent;
        color: #FAF7F2;
        border: 2px solid #FAF7F2;
        text-decoration: none;
        font-size: 14px;
        letter-spacing: 2px;
        text-transform: uppercase;
        transition: all 0.4s ease;
        font-weight: 500;
        cursor: pointer;
    }
    .explore-btn:hover {
        background: #FAF7F2;
        color: #1C1008;
    }
</style>

<!-- Hero Section -->
<section class="spas-hero">
    <h1><em>Feel it before you book it.<br>Warm oils. Soft hands. Deep silence.</em></h1>
    <p>Nepal's best spas await - handpicked sanctuaries where ancient healing tradition meets modern luxury.</p>
    <button class="explore-btn" onclick="document.getElementById('spas-list').scrollIntoView({behavior: 'smooth'});">EXPLORE SPAS</button>
</section>

<!-- Spas Grid -->
<section id="spas-list" class="spas-container">
    @if($spas->count() > 0)
        <div class="spas-grid">
            @foreach($spas as $spa)
                <div class="spa-card">
                    <div class="spa-image">
                        @if($spa->image)
                            <img src="{{ asset('storage/' . $spa->image) }}" alt="{{ $spa->name }}">
                        @endif
                        
                        <div class="price-badge">{{ $spa->price_range }}</div>
                        
                        <div class="favorite-btn">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                    
                    <div class="spa-content">
                        @if($spa->tags && count($spa->tags) > 0)
                            <div class="spa-tags">
                                @foreach(array_slice($spa->tags, 0, 3) as $tag)
                                    <span class="spa-tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        <h3 class="spa-name">{{ $spa->name }}</h3>
                        
                        <div class="spa-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $spa->location }}, {{ $spa->city }}</span>
                        </div>
                        
                        <p class="spa-description">{{ $spa->description }}</p>
                        
                        <div class="spa-footer">
                            <div class="spa-rating">
                                <i class="fas fa-star rating-star"></i>
                                <span class="rating-number">{{ number_format($spa->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="rating-count">({{ $spa->reviews_count ?? 0 }} {{ Str::plural('review', $spa->reviews_count ?? 0) }})</span>
                            </div>
                            
                            <a href="{{ route('spas.show', $spa->id) }}" class="book-btn">See More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-spas">
            <h2>No Spas Available Yet</h2>
            <p>Check back soon for amazing spa experiences!</p>
        </div>
    @endif
</section>

@endsection
