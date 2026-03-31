@extends('layouts.main')

@section('title', 'Hydromassage - SpaLush')

@section('content')

<style>
    .treatment-detail-hero {
        background: linear-gradient(rgba(0,0,0,0.40), rgba(0,0,0,0.40)), 
                    url('https://images.unsplash.com/photo-1596178060671-7a80dc8059ea?w=1920') center/cover;
        padding: 120px 20px 80px;
        text-align: center;
        color: #FAF7F2;
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
        color: #1C1008;
        margin-bottom: 25px;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    
    .treatment-section p {
        font-size: 16px;
        color: rgba(28,16,8,0.7);
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
        background: #FFFFFF;
        padding: 30px;
        border-radius: 8px;
        border-left: 4px solid #C8916A;
    }
    
    .benefit-card h3 {
        font-size: 20px;
        color: #1C1008;
        margin-bottom: 15px;
        font-weight: 500;
    }
    
    .benefit-card p {
        font-size: 15px;
        color: rgba(28,16,8,0.6);
        line-height: 1.7;
        margin: 0;
    }
    
    .treatment-details-box {
        background: #FAF7F2;
        color: #1C1008;
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
        color: #C8916A;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 10px;
        font-weight: 500;
    }
    
    .detail-item p {
        font-size: 18px;
        color: #1C1008;
        margin: 0;
    }
    
    .cta-section {
        text-align: center;
        padding: 80px 20px;
        background: #FAF7F2;
    }
    
    .cta-section h2 {
        font-size: 38px;
        font-weight: 300;
        color: #1C1008;
        margin-bottom: 30px;
        font-family: 'Georgia', serif;
    }
    
    .cta-btn {
        display: inline-block;
        padding: 16px 50px;
        background: #C8916A;
        color: #1C1008;
        text-decoration: none;
        font-size: 14px;
        letter-spacing: 2px;
        text-transform: uppercase;
        transition: all 0.3s ease;
        font-weight: 500;
        border-radius: 4px;
    }
    
    .cta-btn:hover {
        background: #FAF7F2;
    }
</style>

<section class="treatment-detail-hero">
    <h1>Hydromassage</h1>
    <p>Experience the therapeutic power of water with advanced hydromassage therapy</p>
</section>

<div class="treatment-detail-content">
    <div class="treatment-section">
        <h2>About This Treatment</h2>
        <p>
            Hydromassage combines the healing properties of warm water with the therapeutic benefits of massage. Using precisely 
            controlled water jets, this innovative treatment delivers a customizable massage experience that targets specific areas 
            of tension while you remain fully clothed and dry, making it perfect for those seeking immediate relief.
        </p>
        <p>
            Our state-of-the-art hydromassage beds use powerful water jets that can be adjusted in intensity and position to 
            target your specific needs. The combination of heat, buoyancy, and massage creates a unique therapeutic experience 
            that promotes relaxation, reduces muscle tension, and improves circulation. Whether you're recovering from a workout, 
            dealing with chronic pain, or simply need to unwind, hydromassage provides immediate and effective relief.
        </p>
    </div>
    
    <div class="treatment-section">
        <h2>Key Benefits</h2>
        <div class="benefits-grid">
            <div class="benefit-card">
                <h3>Muscle Tension Relief</h3>
                <p>Effectively relieves muscle soreness and tension through targeted water pressure and heat therapy.</p>
            </div>
            <div class="benefit-card">
                <h3>Improved Flexibility</h3>
                <p>Enhances flexibility and range of motion by relaxing tight muscles and improving joint mobility.</p>
            </div>
            <div class="benefit-card">
                <h3>Enhanced Circulation</h3>
                <p>Stimulates blood flow throughout the body, promoting healing and reducing inflammation.</p>
            </div>
            <div class="benefit-card">
                <h3>Stress Reduction</h3>
                <p>Promotes deep relaxation and reduces stress through the soothing combination of warmth and massage.</p>
            </div>
            <div class="benefit-card">
                <h3>Athletic Recovery</h3>
                <p>Accelerates post-workout recovery by reducing lactic acid buildup and muscle fatigue.</p>
            </div>
            <div class="benefit-card">
                <h3>Back Pain Relief</h3>
                <p>Provides targeted relief for back pain and stiffness through customizable water jet positioning.</p>
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
                <p>Muscle Recovery, Pain Relief, Quick Relaxation</p>
            </div>
            <div class="detail-item">
                <h3>Experience Level</h3>
                <p>All Levels Welcome</p>
            </div>
            <div class="detail-item">
                <h3>Recommended Frequency</h3>
                <p>2-3 Times Weekly</p>
            </div>
        </div>
    </div>
</div>

<section class="cta-section">
    <h2>Ready to Experience Hydromassage?</h2>
    <a href="{{ route('spas.index') }}" class="cta-btn">Book Your Session</a>
</section>

@endsection
