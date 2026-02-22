@extends('layouts.main')

@section('title', 'Choose Your Role - SpaLush')

@section('content')

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    .role-selection-wrapper {
        min-height: 100vh;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }
    
    .role-selection-container {
        max-width: 1000px;
        width: 100%;
    }
    
    .header-section {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .header-section h1 {
        color: #1a1a1a;
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .header-section p {
        color: #666666;
        font-size: 18px;
        font-weight: 400;
    }
    
    .role-cards-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }
    
    .role-card {
        background: white;
        border-radius: 16px;
        padding: 45px 35px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 2px solid #e8e8e8;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: block;
    }
    
    .role-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: #c9a961;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .role-card:hover::before {
        transform: scaleX(1);
    }
    
    .role-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 40px rgba(201, 169, 97, 0.2);
        border-color: #c9a961;
    }
    
    .role-icon {
        width: 80px;
        height: 80px;
        background: #c9a961;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin: 0 auto 25px;
        box-shadow: 0 4px 12px rgba(201, 169, 97, 0.3);
        color: white;
    }
    
    .role-card h2 {
        color: #1a1a1a;
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 15px;
    }
    
    .role-description {
        color: #666666;
        font-size: 16px;
        text-align: center;
        margin-bottom: 30px;
        line-height: 1.6;
    }
    
    .features-list {
        list-style: none;
        margin-bottom: 35px;
    }
    
    .features-list li {
        color: #333333;
        font-size: 15px;
        padding: 12px 0;
        padding-left: 35px;
        position: relative;
        line-height: 1.5;
    }
    
    .features-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        top: 12px;
        width: 24px;
        height: 24px;
        background: #c9a961;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
    
    .select-role-btn {
        width: 100%;
        padding: 16px 30px;
        background: #c9a961;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(201, 169, 97, 0.3);
    }
    
    .select-role-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(201, 169, 97, 0.4);
        background: #b8985a;
    }
    
    .footer-links {
        text-align: center;
        margin-top: 30px;
    }
    
    .footer-links p {
        color: #666666;
        font-size: 16px;
    }
    
    .footer-links a {
        color: #c9a961;
        text-decoration: none;
        font-weight: 600;
        border-bottom: 2px solid #c9a961;
        padding-bottom: 2px;
        transition: all 0.3s ease;
    }
    
    .footer-links a:hover {
        color: #b8985a;
        border-bottom-color: #b8985a;
    }
    
    @media (max-width: 768px) {
        .role-cards-container {
            grid-template-columns: 1fr;
        }
        
        .header-section h1 {
            font-size: 32px;
        }
    }
</style>

<div class="role-selection-wrapper">
    <div class="role-selection-container">
        <div class="header-section">
            <h1>Join SpaLush</h1>
            <p>Choose your account type to get started</p>
        </div>
        
        <div class="role-cards-container">
            <!-- Customer Card -->
            <a href="{{ route('usersignup', ['role' => 'customer']) }}" class="role-card">
                <div class="role-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h2>Customer</h2>
                <p class="role-description">
                    Book spa services and enjoy premium wellness experiences
                </p>
                <ul class="features-list">
                    <li>Browse available spa services</li>
                    <li>Book appointments instantly</li>
                    <li>View booking history</li>
                    <li>Manage your profile settings</li>
                    <li>Cancel or reschedule bookings</li>
                </ul>
                <button class="select-role-btn">Sign Up as Customer</button>
            </a>
            
            <!-- Spa Owner Card -->
            <a href="{{ route('usersignup', ['role' => 'spa_owner']) }}" class="role-card">
                <div class="role-icon">
                    <i class="fas fa-spa"></i>
                </div>
                <h2>Spa Owner</h2>
                <p class="role-description">
                    Manage your spa business operations and grow your customer base
                </p>
                <ul class="features-list">
                    <li>Add and manage spa services</li>
                    <li>Handle customer bookings</li>
                    <li>Set your availability schedule</li>
                    <li>View customer records</li>
                    <li>Track earnings and analytics</li>
                </ul>
                <button class="select-role-btn">Sign Up as Spa Owner</button>
            </a>
        </div>
        
        <div class="footer-links">
            <p>Already have an account? <a href="{{ route('userlogin') }}">Login here</a></p>
        </div>
    </div>
</div>

@endsection
