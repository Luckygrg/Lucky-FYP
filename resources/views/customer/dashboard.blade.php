@extends('layouts.main')

@section('title', 'Customer Dashboard - SpaLush')

@section('content')

<div style="max-width: 1200px; margin: 40px auto; padding: 20px;">
    
    <h1 style="color: green; margin-bottom: 10px;">Customer Dashboard</h1>
    <p style="color: #666; margin-bottom: 30px;">Welcome, {{ Auth::user()->name }}!</p>

    @if(session('success'))
        <div style="background: #ccffcc; padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 2px solid green; color: green;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        
        <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="color: green; margin-bottom: 15px;">📅 Book Services</h3>
            <p style="color: #666; margin-bottom: 15px;">Browse and book spa services</p>
            <a href="#" style="display: inline-block; padding: 10px 20px; background: green; color: white; text-decoration: none; border-radius: 4px;">Browse Services</a>
        </div>

        <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="color: green; margin-bottom: 15px;">📋 My Bookings</h3>
            <p style="color: #666; margin-bottom: 15px;">View and manage your bookings</p>
            <a href="#" style="display: inline-block; padding: 10px 20px; background: green; color: white; text-decoration: none; border-radius: 4px;">View Bookings</a>
        </div>

        <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="color: green; margin-bottom: 15px;">👤 My Profile</h3>
            <p style="color: #666; margin-bottom: 15px;">Update your profile information</p>
            <a href="#" style="display: inline-block; padding: 10px 20px; background: green; color: white; text-decoration: none; border-radius: 4px;">Edit Profile</a>
        </div>

    </div>

    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h3 style="color: green; margin-bottom: 15px;">Customer Features</h3>
        <ul style="color: #666; line-height: 2;">
            <li>✓ Register and login to your account</li>
            <li>✓ Browse available spa services</li>
            <li>✓ View service details and pricing</li>
            <li>✓ Check availability of services</li>
            <li>✓ Make bookings for spa services</li>
            <li>✓ View your booking history</li>
            <li>✓ Cancel bookings if needed</li>
            <li>✓ Manage your profile information</li>
        </ul>
    </div>

</div>

@endsection
