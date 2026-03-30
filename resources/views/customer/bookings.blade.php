@extends('layouts.main')
@section('title', 'My Bookings - SpaLush')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    .bookings-page {
        max-width: 900px;
        margin: 60px auto;
        padding: 0 24px 80px;
    }

    .page-header {
        margin-bottom: 36px;
    }

    .page-header h1 {
        font-size: 32px;
        font-weight: 300;
        color: white;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }

    .page-header p {
        color: rgba(255,255,255,0.5);
        font-size: 15px;
    }

    .alert-success {
        background: rgba(67,160,71,0.12);
        color: #6fcf72;
        border: 1px solid rgba(67,160,71,0.3);
        border-radius: 8px;
        padding: 14px 20px;
        margin-bottom: 28px;
        font-size: 14px;
    }

    .alert-error {
        background: rgba(229,57,53,0.12);
        color: #ef9a9a;
        border: 1px solid rgba(229,57,53,0.3);
        border-radius: 8px;
        padding: 14px 20px;
        margin-bottom: 28px;
        font-size: 14px;
    }

    .empty-state {
        background: #2a2a2a;
        border-radius: 12px;
        border: 1px solid rgba(201,169,97,0.15);
        padding: 80px 40px;
        text-align: center;
    }

    .empty-state i {
        font-size: 56px;
        color: rgba(201,169,97,0.4);
        margin-bottom: 20px;
        display: block;
    }

    .empty-state h2 {
        font-size: 22px;
        font-weight: 300;
        color: white;
        font-family: 'Georgia', serif;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: rgba(255,255,255,0.5);
        font-size: 14px;
        margin-bottom: 28px;
    }

    .btn-gold {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: #c9a961;
        color: #1a1a1a;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-gold:hover { background: #b8985a; }

    .booking-card {
        background: #2a2a2a;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.08);
        margin-bottom: 20px;
        overflow: hidden;
        transition: border-color 0.2s;
    }

    .booking-card:hover { border-color: rgba(201,169,97,0.25); }

    .booking-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        flex-wrap: wrap;
        gap: 12px;
    }

    .booking-spa-name {
        font-size: 18px;
        font-weight: 600;
        color: white;
        font-family: 'Georgia', serif;
    }

    .booking-spa-loc {
        font-size: 13px;
        color: rgba(255,255,255,0.45);
        margin-top: 2px;
    }

    .status-badge {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .status-pending   { background: rgba(201,169,97,0.15); color: #c9a961; border: 1px solid rgba(201,169,97,0.3); }
    .status-confirmed { background: rgba(67,160,71,0.15);  color: #6fcf72; border: 1px solid rgba(67,160,71,0.3); }
    .status-completed { background: rgba(100,181,246,0.15); color: #90caf9; border: 1px solid rgba(100,181,246,0.3); }
    .status-cancelled { background: rgba(229,57,53,0.12);  color: #ef9a9a; border: 1px solid rgba(229,57,53,0.3); }

    .booking-body {
        padding: 20px 24px;
    }

    .booking-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 18px;
    }

    .booking-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: rgba(255,255,255,0.65);
    }

    .booking-meta-item i { color: #c9a961; width: 14px; }

    .services-list {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }

    .service-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 14px;
        background: rgba(255,255,255,0.04);
        border-radius: 6px;
        font-size: 13px;
        color: rgba(255,255,255,0.75);
    }

    .service-row .svc-price { color: #c9a961; font-weight: 600; }

    .booking-total {
        display: flex;
        justify-content: space-between;
        padding: 12px 14px;
        background: rgba(201,169,97,0.07);
        border: 1px solid rgba(201,169,97,0.15);
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        color: white;
    }

    .booking-total span { color: #c9a961; }

    .booking-footer {
        padding: 14px 24px;
        border-top: 1px solid rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .booking-notes {
        font-size: 13px;
        color: rgba(255,255,255,0.4);
        font-style: italic;
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 18px;
        background: transparent;
        border: 1px solid rgba(229,57,53,0.4);
        border-radius: 5px;
        color: #ef9a9a;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: rgba(229,57,53,0.1);
        border-color: rgba(229,57,53,0.7);
    }
</style>

<div class="bookings-page">
    <div class="page-header">
        <h1><i class="fas fa-calendar-check" style="color:#c9a961;font-size:26px;margin-right:10px;"></i> My Bookings</h1>
        <p>Track all your spa appointments</p>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    @if(session('info'))
        <div class="alert-success" style="background:rgba(201,169,97,0.12);color:#c9a961;border-color:rgba(201,169,97,0.3);"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    @if($bookings->isEmpty())
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <h2>No bookings yet</h2>
            <p>Discover our spas and book your first experience</p>
            <a href="{{ route('spas.index') }}" class="btn-gold"><i class="fas fa-spa"></i> Explore Spas</a>
        </div>
    @else
        @foreach($bookings as $booking)
        <div class="booking-card">
            <div class="booking-header">
                <div>
                    <div class="booking-spa-name">{{ $booking->spa->name }}</div>
                    <div class="booking-spa-loc"><i class="fas fa-map-marker-alt" style="color:#c9a961;"></i> {{ $booking->spa->city }}</div>
                </div>
                <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
            </div>

            <div class="booking-body">
                <div class="booking-meta">
                    <div class="booking-meta-item">
                        <i class="fas fa-calendar"></i>
                        {{ $booking->booking_date->format('D, d M Y') }}
                    </div>
                    <div class="booking-meta-item">
                        <i class="fas fa-clock"></i>
                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                    </div>
                    <div class="booking-meta-item">
                        <i class="fas fa-hourglass-half"></i>
                        {{ $booking->total_duration_minutes }} min total
                    </div>
                    <div class="booking-meta-item">
                        <i class="fas fa-phone"></i>
                        {{ $booking->phone }}
                    </div>
                </div>

                <div class="services-list">
                    @foreach($booking->bookingServices as $bs)
                        <div class="service-row">
                            <span>{{ $bs->service_name }} <span style="color:rgba(255,255,255,0.35);">· {{ $bs->duration_minutes }} min</span></span>
                            <span class="svc-price">Rs. {{ number_format($bs->price, 0) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="booking-total">
                    <span>Total Amount</span>
                    <span>Rs. {{ number_format($booking->total_price, 0) }}</span>
                </div>
                <div style="margin-top:10px;display:flex;align-items:center;gap:8px;font-size:13px;flex-wrap:wrap;">
                    @if($booking->payment_option === 'pay_now')
                        @if($booking->payment_status === 'paid')
                            <span style="background:rgba(67,160,71,0.12);color:#6fcf72;border:1px solid rgba(67,160,71,0.3);padding:4px 12px;border-radius:12px;font-weight:600;">
                                <i class="fas fa-check-circle"></i> Paid via eSewa
                            </span>
                        @else
                            <span style="background:rgba(201,169,97,0.1);color:#c9a961;border:1px solid rgba(201,169,97,0.25);padding:4px 12px;border-radius:12px;font-weight:600;">
                                <i class="fas fa-clock"></i> Payment Pending
                            </span>
                            @if(in_array($booking->status, ['pending', 'confirmed']))
                                <a href="{{ route('payment.pay', $booking) }}"
                                   style="background:#c9a961;color:#1a1a1a;padding:4px 12px;border-radius:12px;font-weight:700;text-decoration:none;font-size:12px;">
                                    <i class="fas fa-credit-card"></i> Pay with eSewa
                                </a>
                            @endif
                        @endif
                    @else
                        <span style="background:rgba(201,169,97,0.1);color:#c9a961;border:1px solid rgba(201,169,97,0.25);padding:4px 12px;border-radius:12px;font-weight:600;">
                            <i class="fas fa-hand-holding-usd"></i> Pay at Spa
                        </span>
                    @endif
                </div>
            </div>

            <div class="booking-footer">
                <div class="booking-notes">
                    @if($booking->notes)
                        <i class="fas fa-sticky-note"></i> {{ $booking->notes }}
                    @else
                        <span style="opacity:0.4;">No special notes</span>
                    @endif
                </div>

                @if($booking->status === 'pending')
                    <form method="POST" action="{{ route('customer.bookings.cancel', $booking) }}"
                          onsubmit="return confirm('Cancel this booking?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-cancel">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
