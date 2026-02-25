@extends('layouts.main')
@section('content')

<style>
    /* Luxury Homepage Styles */
    .luxury-hero {
        position: relative;
        height: 90vh;
        background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                    url("{{ asset('assets/img/11.jpg') }}") center/cover;
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
        padding: 100px 40px 80px;
        text-align: center;
        background: #1a1a1a;
        position: relative;
        overflow: hidden;
    }

    .welcome-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 1px;
        background: linear-gradient(to right, transparent, #c9a961, transparent);
    }

    .welcome-section::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 1px;
        background: linear-gradient(to right, transparent, #c9a961, transparent);
    }

    .welcome-eyebrow {
        font-size: 11px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: #c9a961;
        margin-bottom: 22px;
        font-weight: 400;
    }

    .welcome-section h2 {
        font-size: 46px;
        font-weight: 300;
        color: #ffffff;
        margin-bottom: 16px;
        font-family: 'Georgia', serif;
        letter-spacing: 2px;
        line-height: 1.2;
    }

    .welcome-subtitle {
        font-size: 15px;
        color: #c9a961;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 300;
        margin-bottom: 36px;
    }

    .welcome-divider {
        width: 60px;
        height: 1px;
        background: #c9a961;
        margin: 0 auto 36px;
    }

    .welcome-section .welcome-body {
        font-size: 16px;
        color: rgba(255,255,255,0.65);
        max-width: 760px;
        margin: 0 auto 20px;
        line-height: 1.95;
        font-weight: 300;
    }

    /* Services Grid */
    .services-luxury {
        max-width: 100%;
        margin: 0 auto;
        padding: 80px 40px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    
    .service-luxury-card {
        position: relative;
        height: 350px;
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
    <p class="welcome-eyebrow">Nepal's Premier Wellness Platform</p>
    <h2>Welcome to Spa Lush</h2>
    <p class="welcome-subtitle">Your one-stop destination for relaxation &amp; wellness</p>
    <div class="welcome-divider"></div>
    <p class="welcome-body">
        Discover and book the finest spa and wellness services across Nepal — all in one place. Spa Lush makes it effortless to browse treatments, check availability and secure your appointment online in just a few clicks.
    </p>
    <p class="welcome-body">
        Whether you're looking for a soothing massage, a therapeutic treatment or a full wellness experience, Spa Lush connects you with trusted spa professionals near you. No more phone calls, no more waiting just seamless, stress-free booking at your fingertips.
    </p>

</section>

<!-- Spa Treatments Section -->
<section class="spa-treatments-section">
    <div class="treatments-container">
        <h2 class="treatments-title">Spa Treatments</h2>
        <p class="treatments-intro">
            A spa treatment is a professional wellness and beauty service provided by trained therapists in a relaxing spa environment. 
            It is designed to improve physical health, enhance skin condition, reduce stress and promote overall well-being. 
            Spa treatments may include massage therapies, skin care services, body cleansing rituals, hydrotherapy and other relaxation-focused experiences. 
            These treatments help clients feel refreshed, balanced and rejuvenated, both physically and mentally.
        </p>
        
        <div class="treatments-grid">
            <!-- Celestial Floatation -->
            <div class="treatment-card">
                <div class="treatment-image">
                    <img src="{{ asset('assets/img/celestial_floatation.jpg') }}" alt="Celestial Floatation">
                </div>
                <div class="treatment-content">
                    <h3 class="treatment-name">Celestial Floatation</h3>
                    <p class="treatment-preview">
                        Experience weightless tranquility in our state-of-the-art floatation pods. Immerse yourself in a sensory deprivation environment that promotes deep relaxation and mental clarity.
                    </p>
                    <a href="{{ route('treatment.celestial-floatation') }}" class="read-more-btn">Read More</a>
                </div>
            </div>
            
            <!-- Mud Ritual -->
            <div class="treatment-card">
                <div class="treatment-image">
                    <img src="{{ asset('assets/img/mud_ritual.jpg') }}" alt="Mud Ritual">
                </div>
                <div class="treatment-content">
                    <h3 class="treatment-name">Mud Ritual</h3>
                    <p class="treatment-preview">
                        Indulge in the ancient healing power of mineral-rich mud therapy. This detoxifying treatment draws out impurities while nourishing your skin with essential minerals.
                    </p>
                    <a href="{{ route('treatment.mud-ritual') }}" class="read-more-btn">Read More</a>
                </div>
            </div>
            
            <!-- Hydromassage -->
            <div class="treatment-card">
                <div class="treatment-image">
                    <img src="{{ asset('assets/img/hydromassage.jpg') }}" alt="Hydromassage">
                </div>
                <div class="treatment-content">
                    <h3 class="treatment-name">Hydromassage</h3>
                    <p class="treatment-preview">
                        Experience the therapeutic power of water with our advanced hydromassage therapy. Targeted water jets provide a customized massage experience without getting wet.
                    </p>
                    <a href="{{ route('treatment.hydromassage') }}" class="read-more-btn">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .spa-treatments-section {
        padding: 40px 20px 100px;
        background: #f5f5f5;
    }
    
    .treatments-container {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .treatments-title {
        font-size: 42px;
        font-weight: 300;
        color: #1a1a1a;
        text-align: center;
        margin-bottom: 30px;
        font-family: 'Georgia', serif;
        letter-spacing: 2px;
    }
    
    .treatments-intro {
        font-size: 16px;
        color: #666;
        text-align: center;
        max-width: 900px;
        margin: 0 auto 40px;
        line-height: 1.8;
        font-weight: 300;
    }
    
    .treatments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    
    .treatment-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .treatment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    
    .treatment-image {
        width: 100%;
        height: 250px;
        overflow: hidden;
    }
    
    .treatment-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .treatment-card:hover .treatment-image img {
        transform: scale(1.05);
    }
    
    .treatment-content {
        padding: 30px;
    }
    
    .treatment-name {
        font-size: 26px;
        font-weight: 400;
        color: #1a1a1a;
        margin-bottom: 15px;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    
    .treatment-preview {
        font-size: 15px;
        color: #666;
        line-height: 1.7;
        margin-bottom: 20px;
    }
    
    .read-more-btn {
        background: transparent;
        color: #c9a961;
        border: 2px solid #c9a961;
        padding: 12px 35px;
        font-size: 13px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        font-weight: 500;
        border-radius: 4px;
        margin-top: 15px;
    }
    
    .read-more-btn:hover {
        background: #c9a961;
        color: white;
    }
    
    @media (max-width: 768px) {
        .treatments-grid {
            grid-template-columns: 1fr;
        }
        
        .treatments-title {
            font-size: 32px;
        }
        
        .treatments-intro {
            font-size: 15px;
        }
    }
</style>

<!-- Services Grid -->
<section class="services-luxury">
    <div class="service-luxury-card">
        <img src="{{ asset('assets/img/Massage.jpg') }}" alt="Massage Therapy">
        <div class="service-overlay">
            <h3>Massage Therapy</h3>
            <p>Indulge in our signature massage treatments designed to release tension and restore balance.</p>
        </div>
    </div>
    
    <div class="service-luxury-card">
        <img src="{{ asset('assets/img/Facial.jpg') }}" alt="Facial Treatments">
        <div class="service-overlay">
            <h3>Facial Treatments</h3>
            <p>Rejuvenate your skin with our luxurious facial treatments using premium organic products.</p>
        </div>
    </div>
    
    <div class="service-luxury-card">
        <img src="{{ asset('assets/img/Body.jpg') }}" alt="Body Treatments">
        <div class="service-overlay">
            <h3>Body Treatments</h3>
            <p>Experience complete body renewal with our exclusive body wraps and scrubs.</p>
        </div>
    </div>
    
    <div class="service-luxury-card">
        <img src="{{ asset('assets/img/Stone.jpg') }}" alt="Hot Stone Therapy">
        <div class="service-overlay">
            <h3>Hot Stone Therapy</h3>
            <p>Melt away stress with heated volcanic stones that penetrate deep into muscles, easing tension and restoring warmth.</p>
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