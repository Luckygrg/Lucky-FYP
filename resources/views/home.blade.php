@extends('layouts.main')

@section('title', 'Welcome to Spa Lush - Nepal\'s Premier Spa Booking Platform')

@section('hyasabcontentauncha')
<style>
    .hero-section {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%),
                    url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1200') center/cover;
        color: white;
        padding: 100px 20px;
        text-align: center;
    }

    .hero-section h1 {
        font-size: 48px;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .hero-section p {
        font-size: 20px;
        margin-bottom: 30px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .cta-button {
        display: inline-block;
        background: white;
        color: #667eea;
        padding: 15px 40px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 18px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .features {
        max-width: 1200px;
        margin: 80px auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
    }

    .feature-card {
        text-align: center;
        padding: 30px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .feature-icon {
        font-size: 60px;
        margin-bottom: 20px;
    }

    .feature-card h3 {
        color: #667eea;
        margin-bottom: 15px;
        font-size: 24px;
    }

    .feature-card p {
        color: #666;
        line-height: 1.6;
    }

    .stats-section {
        background: #f8f9fa;
        padding: 60px 20px;
        text-align: center;
    }

    .stats-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 40px;
    }

    .stat-item h2 {
        color: #667eea;
        font-size: 48px;
        margin-bottom: 10px;
    }

    .stat-item p {
        color: #666;
        font-size: 18px;
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <h1>Welcome to Spa Lush</h1>
    <p>Nepal's Premier Online Platform for Spa & Wellness Services. Book your perfect relaxation experience today!</p>
    <a href="{{ route('usersignup') }}" class="cta-button">Get Started</a>
</section>

<!-- Features Section -->
<section class="features">
    <div class="feature-card">
        <div class="feature-icon">🧘</div>
        <h3>Easy Booking</h3>
        <p>Browse and book spa services from the comfort of your home. Simple, fast, and hassle-free!</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">💆</div>
        <h3>Verified Spas</h3>
        <p>All spa owners are verified to ensure you get the best quality service every time.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">💳</div>
        <h3>Secure Payment</h3>
        <p>Safe and secure online payment options for your peace of mind.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">⏰</div>
        <h3>Real-Time Updates</h3>
        <p>Get instant booking confirmations and notifications for all your appointments.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">📱</div>
        <h3>Mobile Friendly</h3>
        <p>Book on the go! Our platform works seamlessly on all your devices.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">⭐</div>
        <h3>Best Services</h3>
        <p>Access to Nepal's finest spa and wellness centers all in one place.</p>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <h2 style="color: #333; margin-bottom: 50px; font-size: 36px;">Why Choose Spa Lush?</h2>
    <div class="stats-container">
        <div class="stat-item">
            <h2>50+</h2>
            <p>Partner Spas</p>
        </div>
        <div class="stat-item">
            <h2>1000+</h2>
            <p>Happy Customers</p>
        </div>
        <div class="stat-item">
            <h2>5000+</h2>
            <p>Bookings Completed</p>
        </div>
        <div class="stat-item">
            <h2>4.8★</h2>
            <p>Average Rating</p>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 80px 20px; text-align: center;">
    <h2 style="font-size: 36px; margin-bottom: 20px;">Ready to Relax?</h2>
    <p style="font-size: 18px; margin-bottom: 30px;">Join thousands of satisfied customers and book your wellness experience today!</p>
    <a href="{{ route('usersignup') }}" class="cta-button">Sign Up Now</a>
</section>
@endsection