@extends('layouts.main')
@section('content')

<style>
    /* Luxury Homepage Styles */
    .luxury-hero {
        position: relative;
        height: 90vh;
        background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                    url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1920') center/cover;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
    }
    
    .luxury-hero-content {
        max-width: 800px;
        padding: 0 20px;
        animation: fadeInUp 1s ease-out;
    }
    
    .luxury-hero h1 {
        font-size: 56px;
        font-weight: 300;
        letter-spacing: 3px;
        margin-bottom: 20px;
        text-transform: uppercase;
        font-family: 'Georgia', serif;
    }
    
    .luxury-hero p {
        font-size: 20px;
        font-weight: 300;
        letter-spacing: 1px;
        margin-bottom: 40px;
        line-height: 1.8;
    }
    
    .luxury-btn {
        display: inline-block;
        padding: 16px 50px;
        background: transparent;
        color: white;
        border: 2px solid white;
        text-decoration: none;
        font-size: 14px;
        letter-spacing: 2px;
        text-transform: uppercase;
        transition: all 0.4s ease;
        font-weight: 500;
    }
    
    .luxury-btn:hover {
        background: white;
        color: #1a1a1a;
    }
    
    /* Welcome Section */
    .welcome-section {
        padding: 100px 20px;
        text-align: center;
        background: #f9f9f9;
    }
    
    .welcome-section h2 {
        font-size: 42px;
        font-weight: 300;
        color: #1a1a1a;
        margin-bottom: 20px;
        font-family: 'Georgia', serif;
        letter-spacing: 2px;
    }
    
    .welcome-section p {
        font-size: 18px;
        color: #666;
        max-width: 700px;
        margin: 0 auto 50px;
        line-height: 1.8;
        font-weight: 300;
    }
    
    /* Services Grid */
    .services-luxury {
        max-width: 1400px;
        margin: 0 auto;
        padding: 80px 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 40px;
    }
    
    .service-luxury-card {
        position: relative;
        height: 450px;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    
    .service-luxury-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    
    .service-luxury-card:hover img {
        transform: scale(1.1);
    }
    
    .service-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        padding: 40px 30px;
        color: white;
    }
    
    .service-overlay h3 {
        font-size: 28px;
        font-weight: 300;
        margin-bottom: 10px;
        letter-spacing: 1px;
        font-family: 'Georgia', serif;
    }
    
    .service-overlay p {
        font-size: 15px;
        font-weight: 300;
        opacity: 0.9;
        line-height: 1.6;
    }
    
    /* Experience Section */
    .experience-section {
        background: #1a1a1a;
        color: white;
        padding: 100px 20px;
        text-align: center;
    }
    
    .experience-section h2 {
        font-size: 42px;
        font-weight: 300;
        margin-bottom: 60px;
        font-family: 'Georgia', serif;
        letter-spacing: 2px;
    }
    
    .experience-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 50px;
    }
    
    .experience-item {
        padding: 20px;
    }
    
    .experience-icon {
        font-size: 48px;
        margin-bottom: 20px;
    }
    
    .experience-item h3 {
        font-size: 20px;
        font-weight: 400;
        margin-bottom: 15px;
        letter-spacing: 1px;
    }
    
    .experience-item p {
        font-size: 15px;
        font-weight: 300;
        opacity: 0.8;
        line-height: 1.7;
    }
    
    /* Stats Luxury */
    .stats-luxury {
        padding: 100px 20px;
        background: white;
    }
    
    .stats-luxury-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 60px;
        text-align: center;
    }
    
    .stat-luxury-item h3 {
        font-size: 56px;
        font-weight: 300;
        color: #c9a961;
        margin-bottom: 10px;
        font-family: 'Georgia', serif;
    }
    
    .stat-luxury-item p {
        font-size: 16px;
        color: #666;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 13px;
    }
    
    /* CTA Luxury */
    .cta-luxury {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                    url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=1920') center/cover fixed;
        padding: 120px 20px;
        text-align: center;
        color: white;
    }
    
    .cta-luxury h2 {
        font-size: 48px;
        font-weight: 300;
        margin-bottom: 20px;
        font-family: 'Georgia', serif;
        letter-spacing: 2px;
    }
    
    .cta-luxury p {
        font-size: 18px;
        font-weight: 300;
        margin-bottom: 40px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.8;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @media (max-width: 768px) {
        .luxury-hero h1 {
            font-size: 36px;
        }
        
        .luxury-hero p {
            font-size: 16px;
        }
        
        .services-luxury {
            grid-template-columns: 1fr;
        }
        
        .welcome-section h2,
        .experience-section h2,
        .cta-luxury h2 {
            font-size: 32px;
        }
    }
</style>

<!-- Luxury Hero Section -->
<section class="luxury-hero">
    <div class="luxury-hero-content">
        <h1>Experience the Magic of SpaLush</h1>
        <p>Welcome to a world where wellness meets wonder. Discover the beauty of tranquility and an ethos encompassing wellbeing from around Nepal.</p>
        @guest
            <a href="{{ route('role.selection') }}" class="luxury-btn">Begin Your Journey</a>
        @else
            <a href="/dashboard" class="luxury-btn">Explore Spas</a>
        @endguest
    </div>
</section>

<!-- Welcome Section -->
<section class="welcome-section">
    <h2>A Sanctuary of Serenity</h2>
    <p>At SpaLush, we believe in the transformative power of touch, the healing properties of nature, and the importance of taking time for yourself. Our curated collection of premium spa experiences brings you the finest wellness destinations across Nepal.</p>
</section>

<!-- Services Grid -->
<section class="services-luxury">
    <div class="service-luxury-card">
        <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800" alt="Massage Therapy">
        <div class="service-overlay">
            <h3>Massage Therapy</h3>
            <p>Indulge in our signature massage treatments designed to release tension and restore balance.</p>
        </div>
    </div>
    
    <div class="service-luxury-card">
        <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800" alt="Facial Treatments">
        <div class="service-overlay">
            <h3>Facial Treatments</h3>
            <p>Rejuvenate your skin with our luxurious facial treatments using premium organic products.</p>
        </div>
    </div>
    
    <div class="service-luxury-card">
        <img src="https://images.unsplash.com/photo-1545205597-3d9d02c29597?w=800" alt="Body Treatments">
        <div class="service-overlay">
            <h3>Body Treatments</h3>
            <p>Experience complete body renewal with our exclusive body wraps and scrubs.</p>
        </div>
    </div>
</section>

<!-- Experience Section -->
<section class="experience-section">
    <h2>The SpaLush Experience</h2>
    <div class="experience-grid">
        <div class="experience-item">
            <div class="experience-icon">✨</div>
            <h3>Premium Quality</h3>
            <p>Only the finest spas and wellness centers, carefully selected for excellence.</p>
        </div>
        
        <div class="experience-item">
            <div class="experience-icon">🌿</div>
            <h3>Natural Products</h3>
            <p>Organic and natural treatments that honor your body and the environment.</p>
        </div>
        
        <div class="experience-item">
            <div class="experience-icon">👐</div>
            <h3>Expert Therapists</h3>
            <p>Highly trained professionals dedicated to your wellness journey.</p>
        </div>
        
        <div class="experience-item">
            <div class="experience-icon">🎯</div>
            <h3>Personalized Care</h3>
            <p>Tailored treatments designed specifically for your unique needs.</p>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-luxury">
    <div class="stats-luxury-grid">
        <div class="stat-luxury-item">
            <h3>50+</h3>
            <p>Premium Spa Partners</p>
        </div>
        <div class="stat-luxury-item">
            <h3>1000+</h3>
            <p>Satisfied Guests</p>
        </div>
        <div class="stat-luxury-item">
            <h3>5000+</h3>
            <p>Treatments Completed</p>
        </div>
        <div class="stat-luxury-item">
            <h3>4.8★</h3>
            <p>Average Rating</p>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-luxury">
    @guest
        <h2>Begin Your Wellness Journey</h2>
        <p>Join our community of wellness enthusiasts and discover the transformative power of self-care.</p>
        <a href="{{ route('role.selection') }}" class="luxury-btn">Reserve Your Experience</a>
    @else
        <h2>Welcome Back, {{ Auth::user()->name }}</h2>
        <p>Your next moment of tranquility awaits. Explore our collection of premium spa experiences.</p>
        <a href="/dashboard" class="luxury-btn">View Available Spas</a>
    @endguest
</section>

@endsection