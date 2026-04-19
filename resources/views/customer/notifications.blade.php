@extends('layouts.main')
@section('title', 'Notifications - SpaLush')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    body { background: #FAF7F2; }

    .notifications-page {
        max-width: 800px;
        margin: 60px auto;
        padding: 0 24px 80px;
    }

    .page-header { margin-bottom: 36px; }

    .page-header h1 {
        font-size: 32px;
        font-weight: 300;
        color: #1C1008;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }

    .page-header p {
        color: rgba(28,16,8,0.5);
        font-size: 15px;
    }

    .notification-list {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .notification-item {
        background: #fff;
        border-radius: 8px;
        border: 1px solid rgba(200,145,106,0.15);
        padding: 18px 22px;
        font-size: 15px;
        color: #1C1008;
        box-shadow: 0 2px 8px rgba(200,145,106,0.04);
    }
</style>

<div class="notifications-page">
    <div class="page-header">
        <h1><i class="fas fa-bell" style="color:#C8916A;font-size:26px;margin-right:10px;"></i> Notifications</h1>
        <p>Stay updated on your bookings and payments</p>
    </div>
    <div style="background:#fff;border-radius:16px;padding:60px 0;text-align:center;box-shadow:0 2px 8px rgba(200,145,106,0.04);">
        <i class="fas fa-bell-slash" style="font-size:64px;color:#e5d3c0;margin-bottom:18px;"></i>
        <div style="font-size:2rem;font-family:'Georgia',serif;font-weight:400;margin-bottom:10px;">No Notifications Yet</div>
        <div style="color:#a89b8a;font-size:1.1rem;">You'll be notified about bookings, payments, and updates here.</div>
    </div>
</div>
@endsection
