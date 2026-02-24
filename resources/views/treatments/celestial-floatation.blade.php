@extends('layouts.main')

@section('title', 'Celestial Floatation - SpaLush')

@section('content')

<style>
    .treatment-detail-hero {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                    url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=1920') center/cover;
        padding: 120px 20px 80px;
        text-align: center;
        color: white;
    }
    
    .treatment-detail-hero h1 {
        font-size: 52px;
        font-weight: 300;
        letter-spacing: 2px;
        margin-bottom: 20px;
        font-family: 'Georgia', serif;
    }
    
    .treatment-detail-hero p {
        font-size: 20px;
        font-weight: 300;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.8;
    }
    
    .treatment-detail-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 40px;
    }
    
    .treatment-section {
        margin-bottom: 60px;
    }
    
    .treatment-section h2 {
        font-size: 36px;
        font-weight: 300;
        color: #1a1a1a;
        margin-bottom: 25px;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    
    .treatment-section p {
        font-size: 16px;
        color: #666;
        line-height: 1.9;
        margin-bottom: 20px;
    }
    
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    
    .benefit-card {
        background: #f5f5f5;
        padding: 30px;
        border-radius: 8px;
        border-left: 4px solid #c9a961;
    }
    
    .benefit-card h3 {
        font-size: 20px;
        color: #1a1a1a;
        margin-bottom: 15px;
        font-weight: 500;
    }
    
    .benefit-card p {
        font-size: 15px;
        color: #666;
        line-height: 1.7;
        margin: 0;
    }
    
    .treatment-details-box {
        background: #1a1a1a;
        color: white;
        padding: 50px;
        border-radius: 8px;
        margin-top: 60px;
    }
    
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
    }
    
    .detail-item h3 {
        font-size: 14px;
        color: #c9a961;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 10px;
        font-weight: 500;
    }
    
    .detail-item p {
        font-size: 18px;
        color: white;
        margin: 0;
    }
    
    .cta-section {
        text-align: center;
        padding: 80px 20px;
        background: #f5f5f5;
    }
    
    .cta-section h2 {
        font-size: 38px;
        font-weight: 300;
        color: #1a1a1a;
        margin-bottom: 30px;
        font-family: 'Georgia', serif;
    }
    
    .cta-btn {
        display: inline-block;
        padding: 16px 50px;
        background: #c9a961;
        color: white;
        text-decoration: none;
        font-size: 14px;
        letter-spacing: 2px;
        text-transform: uppercase;
        transition: all 0.3s ease;
        font-weight: 500;
        border-radius: 4px;
    }
    
    .cta-btn:hover {
        background: #1a1a1a;
    }
</style>

<section class="treatment-detail-hero">
    <h1>Celestial Floatation</h1>
    <p>Experience weightless tranquility in our state-of-the-art floatation pods</p>
</section>

<div class="treatment-detail-content">
    <div class="treatment-section">
        <h2>About This Treatment</h2>
        <p>
            Celestial Floatation is an innovative wellness experience that combines the ancient practice of sensory deprivation 
            with modern technology. Float effortlessly in body-temperature water saturated with Epsom salts, creating a zero-gravity 
            environment that allows your body and mind to achieve profound relaxation.
        </p>
        <p>
            In this peaceful sanctuary, free from external stimuli, your nervous system enters a deeply restorative state. 
            The high concentration of magnesium-rich Epsom salts not only creates buoyancy but also provides therapeutic benefits 
            for your muscles and joints. This unique environment promotes the release of endorphins, reduces cortisol levels, 
            and allows your mind to enter a meditative state naturally.
        </p>
    </div>
    
    <div class="treatment-section">
        <h2>Key Benefits</h2>
        <div class="benefits-grid">
            <div class="benefit-card">
                <h3>Stress & Anxiety Relief</h3>
                <p>Significantly reduces stress hormones and promotes deep mental relaxation through sensory deprivation.</p>
            </div>
            <div class="benefit-card">
                <h3>Pain Management</h3>
                <p>Relieves muscle tension, chronic pain, and joint discomfort through weightless floating and magnesium absorption.</p>
            </div>
            <div class="benefit-card">
                <h3>Mental Clarity</h3>
                <p>Enhances creativity, focus, and cognitive function by allowing the brain to enter theta wave states.</p>
            </div>
            <div class="benefit-card">
                <h3>Better Sleep</h3>
                <p>Improves sleep quality and patterns by resetting your circadian rhythm and promoting deep relaxation.</p>
            </div>
            <div class="benefit-card">
                <h3>Athletic Recovery</h3>
                <p>Accelerates recovery from physical exertion by reducing lactic acid and promoting muscle repair.</p>
            </div>
            <div class="benefit-card">
                <h3>Meditation Enhancement</h3>
                <p>Creates the perfect environment for deep meditation and mindfulness practice without years of training.</p>
            </div>
        </div>
    </div>
    
    <div class="treatment-details-box">
        <div class="details-grid">
            <div class="detail-item">
                <h3>Duration</h3>
                <p>60 Minutes</p>
            </div>
            <div class="detail-item">
                <h3>Ideal For</h3>
                <p>Stress Relief, Mental Clarity, Pain Management</p>
            </div>
            <div class="detail-item">
                <h3>Experience Level</h3>
                <p>All Levels Welcome</p>
            </div>
            <div class="detail-item">
                <h3>Recommended Frequency</h3>
                <p>Weekly for Optimal Results</p>
            </div>
        </div>
    </div>
</div>

<section class="cta-section">
    <h2>Ready to Experience Celestial Floatation?</h2>
    <a href="{{ route('spas.index') }}" class="cta-btn">Book Your Session</a>
</section>

@endsection
