@extends('layouts.main')

@section('title', 'Mud Ritual - SpaLush')

@section('content')

<style>
    .treatment-detail-hero {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                    url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1920') center/cover;
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
    <h1>Mud Ritual</h1>
    <p>Indulge in the ancient healing power of mineral-rich mud therapy</p>
</section>

<div class="treatment-detail-content">
    <div class="treatment-section">
        <h2>About This Treatment</h2>
        <p>
            The Mud Ritual is a time-honored therapeutic treatment that harnesses the natural healing properties of mineral-rich 
            mud from pristine sources. This luxurious body treatment detoxifies, exfoliates, and revitalizes your skin while 
            providing deep relaxation and therapeutic benefits for your entire body.
        </p>
        <p>
            Our carefully selected therapeutic mud contains a rich blend of minerals including magnesium, calcium, potassium, 
            and trace elements that penetrate deep into your skin. As the warm mud is applied to your body, it draws out 
            impurities and toxins while simultaneously nourishing your skin with essential minerals. The heat from the mud 
            also helps to relax muscles, improve circulation, and reduce inflammation throughout your body.
        </p>
    </div>
    
    <div class="treatment-section">
        <h2>Key Benefits</h2>
        <div class="benefits-grid">
            <div class="benefit-card">
                <h3>Deep Detoxification</h3>
                <p>Draws out impurities and toxins from deep within the skin, leaving you feeling cleansed and refreshed.</p>
            </div>
            <div class="benefit-card">
                <h3>Skin Rejuvenation</h3>
                <p>Improves skin texture, tone, and elasticity through natural exfoliation and mineral nourishment.</p>
            </div>
            <div class="benefit-card">
                <h3>Anti-Inflammatory</h3>
                <p>Reduces inflammation and provides relief for joint pain, arthritis, and muscle aches.</p>
            </div>
            <div class="benefit-card">
                <h3>Circulation Boost</h3>
                <p>Stimulates blood flow throughout the body, promoting healing and cellular regeneration.</p>
            </div>
            <div class="benefit-card">
                <h3>Muscle Relief</h3>
                <p>Relieves muscle tension and stiffness through the therapeutic warmth and mineral absorption.</p>
            </div>
            <div class="benefit-card">
                <h3>Mineral Therapy</h3>
                <p>Provides essential minerals directly to your skin, supporting overall health and vitality.</p>
            </div>
        </div>
    </div>
    
    <div class="treatment-details-box">
        <div class="details-grid">
            <div class="detail-item">
                <h3>Duration</h3>
                <p>75 Minutes</p>
            </div>
            <div class="detail-item">
                <h3>Ideal For</h3>
                <p>Detoxification, Skin Rejuvenation, Arthritis Relief</p>
            </div>
            <div class="detail-item">
                <h3>Experience Level</h3>
                <p>All Levels Welcome</p>
            </div>
            <div class="detail-item">
                <h3>Recommended Frequency</h3>
                <p>Monthly for Maintenance</p>
            </div>
        </div>
    </div>
</div>

<section class="cta-section">
    <h2>Ready to Experience the Mud Ritual?</h2>
    <a href="{{ route('spas.index') }}" class="cta-btn">Book Your Session</a>
</section>

@endsection
