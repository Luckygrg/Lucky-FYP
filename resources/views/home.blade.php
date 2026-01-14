@extends('layouts.main')
@section('content')


<!-- Hero Section -->
<section class="hero-section">
    <h1>Welcome to Spa Lush</h1>
    <p>Nepal's Premier Online Platform for Spa & Wellness Services. Book your perfect relaxation experience today.</p>
    
    @guest
        {{-- Show this button ONLY if user is NOT logged in --}}
        <a href="{{ route('usersignup') }}" class="cta-button">Get Started</a>
    @else
        {{-- Show this button ONLY if user IS logged in --}}
        <a href="/dashboard" class="cta-button">Browse Spas</a>
    @endguest
</section>

<!-- Features Section -->
<section class="features">
    <div class="feature-card">
        <h3>Easy Booking</h3>
        <p>Browse and book spa services from the comfort of your home. Simple, fast, and hassle-free booking process.</p>
    </div>

    <div class="feature-card">
        <h3>Verified Spas</h3>
        <p>All spa owners are verified to ensure you get the best quality service every time you visit.</p>
    </div>

    <div class="feature-card">
        <h3>Secure Payment</h3>
        <p>Safe and secure online payment options for your peace of mind and convenience.</p>
    </div>

    <div class="feature-card">
        <h3>Real-Time Updates</h3>
        <p>Get instant booking confirmations and notifications for all your appointments.</p>
    </div>

    <div class="feature-card">
        <h3>Mobile Friendly</h3>
        <p>Book on the go! Our platform works seamlessly on all your devices.</p>
    </div>

    <div class="feature-card">
        <h3>Best Services</h3>
        <p>Access to Nepal's finest spa and wellness centers all in one convenient place.</p>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <h2>Why Choose Spa Lush?</h2>
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
            <h2>4.8</h2>
            <p>Average Rating</p>
        </div>
    </div>
</section>

<!-- CTA Section - Different for guests vs logged in users -->
<section class="cta-section">
    @guest
        {{-- Show this ONLY if user is NOT logged in --}}
        <h2>Ready to Relax?</h2>
        <p>Join thousands of satisfied customers and book your wellness experience today.</p>
        <a href="{{ route('usersignup') }}" class="cta-button">Sign Up Now</a>
    @else
        {{-- Show this ONLY if user IS logged in --}}
        <h2>Welcome back, {{ Auth::user()->name }}!</h2>
        <p>Ready to book your next spa experience?</p>
        <a href="/dashboard" class="cta-button">View Available Spas</a>
    @endguest
</section>

@endsection