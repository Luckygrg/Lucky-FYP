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

    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        color: #C8916A; text-decoration: none; font-size: 14px; margin-bottom: 22px;
    }
    .back-link:hover { color: #AE7A55; }

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
        gap: 12px;
    }

    .notification-card {
        background: #FFFFFF;
        border-radius: 12px;
        border: 1px solid rgba(28,16,8,0.08);
        padding: 20px 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        transition: border-color 0.2s;
    }

    .notification-card:hover { border-color: rgba(200,145,106,0.25); }

    .notification-card.unread {
        border-left: 4px solid #C8916A;
        background: rgba(200,145,106,0.04);
    }

    .notification-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: rgba(200,145,106,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .notification-icon i {
        font-size: 16px;
        color: #C8916A;
    }

    .notification-content { flex: 1; }

    .notification-message {
        font-size: 14px;
        color: rgba(28,16,8,0.75);
        line-height: 1.55;
        margin-bottom: 6px;
    }

    .notification-time {
        font-size: 12px;
        color: rgba(28,16,8,0.4);
        letter-spacing: 0.5px;
    }

    .empty-state {
        background: #FFFFFF;
        border-radius: 12px;
        border: 1px solid rgba(200,145,106,0.15);
        padding: 80px 40px;
        text-align: center;
    }

    .empty-state i {
        font-size: 56px;
        color: rgba(200,145,106,0.4);
        margin-bottom: 20px;
        display: block;
    }

    .empty-state h2 {
        font-size: 22px;
        font-weight: 300;
        color: #1C1008;
        font-family: 'Georgia', serif;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: rgba(28,16,8,0.5);
        font-size: 14px;
    }

    .pagination-wrap {
        margin-top: 24px;
        display: flex;
        justify-content: center;
    }
</style>

<div class="notifications-page">
    <a href="/" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>

    <div class="page-header">
        <h1><i class="fas fa-bell" style="color:#C8916A;font-size:26px;margin-right:10px;"></i> Notifications</h1>
        <p>Stay updated on your bookings and payments</p>
    </div>

    @if($notifications->count() > 0)
        <div class="notification-list">
            @foreach($notifications as $notification)
                <div class="notification-card {{ is_null($notification->read_at) ? 'unread' : '' }}">
                    <div class="notification-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-message">
                            {{ $notification->data['message'] ?? 'You have a new notification.' }}
                        </div>
                        <div class="notification-time">
                            <i class="far fa-clock" style="margin-right:4px;"></i> {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-bell-slash"></i>
            <h2>No Notifications Yet</h2>
            <p>You'll be notified about bookings, payments, and updates here.</p>
        </div>
    @endif
</div>
@endsection
