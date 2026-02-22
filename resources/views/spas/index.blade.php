@extends('layouts.main')

@section('title', 'Our Spas - SpaLush')

@section('content')

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    .spas-hero {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                    url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1920') center/cover;
        padding: 100px 20px;
        text-align: center;
        color: white;
    }
    
    .spas-hero h1 {
        font-size: 48px;
        font-weight: 300;
        letter-spacing: 2px;
        margin-bottom: 15px;
        font-family: 'Georgia', serif;
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
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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
        background: linear-gradient(135deg, #c9a961 0%, #8b7644 100%);
        position: relative;
        overflow: hidden;
    }
    
    .spa-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .featured-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #c9a961;
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .price-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: white;
        color: #1a1a1a;
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
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .favorite-btn:hover {
        background: #c9a961;
        color: white;
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
        color: #666;
        background: #f5f5f5;
        padding: 4px 12px;
        border-radius: 12px;
    }
    
    .spa-name {
        font-size: 22px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
        font-family: 'Georgia', serif;
    }
    
    .spa-location {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #666;
        font-size: 14px;
        margin-bottom: 12px;
    }
    
    .spa-description {
        color: #666;
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
        border-top: 1px solid #f0f0f0;
    }
    
    .spa-rating {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .rating-star {
        color: #c9a961;
        font-size: 16px;
    }
    
    .rating-number {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 15px;
    }
    
    .rating-count {
        color: #999;
        font-size: 13px;
    }
    
    .book-btn {
        padding: 10px 24px;
        background: #1a1a1a;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .book-btn:hover {
        background: #c9a961;
    }
    
    .no-spas {
        text-align: center;
        padding: 80px 20px;
        color: #666;
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
</style>

<!-- Hero Section -->
<section class="spas-hero">
    <h1>Discover Our Spas</h1>
    <p>Explore premium wellness destinations across Nepal</p>
</section>

<!-- Spas Grid -->
<section class="spas-container">
    @if($spas->count() > 0)
        <div class="spas-grid">
            @foreach($spas as $spa)
                <div class="spa-card">
                    <div class="spa-image">
                        @if($spa->image)
                            <img src="{{ asset('storage/' . $spa->image) }}" alt="{{ $spa->name }}">
                        @endif
                        
                        @if($spa->is_featured)
                            <div class="featured-badge">
                                <i class="fas fa-star"></i> Featured
                            </div>
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
                                <span class="rating-number">{{ number_format($spa->rating, 1) }}</span>
                                <span class="rating-count">({{ $spa->review_count }} reviews)</span>
                            </div>
                            
                            <a href="{{ route('spas.show', $spa->id) }}" class="book-btn">Book Now</a>
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
