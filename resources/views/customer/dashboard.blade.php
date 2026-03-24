@extends('layouts.main')

@section('title', 'Customer Dashboard - SpaLush')

@section('content')

<div style="max-width: 1200px; margin: 40px auto; padding: 20px;">
    
    <h1 style="color: #c9a961; margin-bottom: 10px;">Customer Dashboard</h1>
    <p style="color: rgba(255,255,255,0.6); margin-bottom: 30px;">Welcome, {{ Auth::user()->name }}!</p>

    @if(session('success'))
        <div style="background: rgba(201,169,97,0.15); padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #c9a961; color: #c9a961;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        
        <div style="background: #2a2a2a; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.3); border: 1px solid rgba(201,169,97,0.15);">
            <h3 style="color: #c9a961; margin-bottom: 15px;"> Book Services</h3>
            <p style="color: rgba(255,255,255,0.6); margin-bottom: 15px;">Browse and book spa services</p>
            <a href="#" style="display: inline-block; padding: 10px 20px; background: #c9a961; color: #1a1a1a; text-decoration: none; border-radius: 4px; font-weight: 600;">Browse Services</a>
        </div>

        <div style="background: #2a2a2a; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.3); border: 1px solid rgba(201,169,97,0.15);">
            <h3 style="color: #c9a961; margin-bottom: 15px;"> My Bookings</h3>
            <p style="color: rgba(255,255,255,0.6); margin-bottom: 15px;">View and manage your bookings</p>
            <a href="#" style="display: inline-block; padding: 10px 20px; background: #c9a961; color: #1a1a1a; text-decoration: none; border-radius: 4px; font-weight: 600;">View Bookings</a>
        </div>

        <div style="background: #2a2a2a; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.3); border: 1px solid rgba(201,169,97,0.15);">
            <h3 style="color: #c9a961; margin-bottom: 15px;"> My Profile</h3>
            <p style="color: rgba(255,255,255,0.6); margin-bottom: 15px;">Update your profile information</p>
            <a href="#" style="display: inline-block; padding: 10px 20px; background: #c9a961; color: #1a1a1a; text-decoration: none; border-radius: 4px; font-weight: 600;">Edit Profile</a>
        </div>

    </div>

    <div style="background: #2a2a2a; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.3); border: 1px solid rgba(201,169,97,0.15);">
        <h3 style="color: #c9a961; margin-bottom: 15px;">Customer Features</h3>
        <ul style="color: rgba(255,255,255,0.7); line-height: 2;">
            <li> Register and login to your account</li>
            <li> Browse available spa services</li>
            <li> View service details and pricing</li>
            <li> Check availability of services</li>
            <li> Make bookings for spa services</li>
            <li> View your booking history</li>
            <li> Cancel bookings if needed</li>
            <li> Manage your profile information</li>
        </ul>
    </div>

</div>

@endsection
