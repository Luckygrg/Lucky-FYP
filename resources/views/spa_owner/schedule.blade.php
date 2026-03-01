@extends('layouts.main')
@section('title', 'Schedule - SpaLush')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    .dashboard-container { display: flex; min-height: 100vh; background: #f8f9fa; font-family: Arial, sans-serif; }
    .main-content { flex: 1; padding: 40px; overflow-y: auto; }
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 28px; color: #1a1a1a; font-weight: 300; font-family: 'Georgia', serif; letter-spacing: 1px; }
    .page-header p { color: #888; font-size: 15px; margin-top: 8px; }
    .placeholder-card { background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 80px 40px; text-align: center; }
    .placeholder-icon { font-size: 64px; margin-bottom: 20px; }
    .placeholder-card h2 { font-size: 24px; color: #1a1a1a; font-weight: 300; font-family: 'Georgia', serif; margin-bottom: 12px; }
    .placeholder-card p { color: #888; font-size: 15px; }
    .badge-coming { display: inline-block; background: #fff8e1; color: #8b6914; border: 1px solid #f0b429; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-top: 20px; }
</style>

<div class="dashboard-container">
    @include('spa_owner.partials.sidebar')

    <div class="main-content">
        <div class="page-header">
            <h1>🕐 Schedule</h1>
            <p>Set your spa's availability and manage time slots</p>
        </div>

        <div class="placeholder-card">
            <div class="placeholder-icon">🕐</div>
            <h2>Schedule Management</h2>
            <p>Define working hours, block off days, and configure availability for {{ $spa ? $spa->name : 'your spa' }}.</p>
            <span class="badge-coming">⏳ Coming Soon</span>
        </div>
    </div>
</div>
@endsection
