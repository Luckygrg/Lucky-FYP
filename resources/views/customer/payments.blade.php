@extends('layouts.main')
@section('title', 'Payment History - SpaLush')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    .payments-page {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 24px 80px;
    }

    .payments-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    @media (max-width: 768px) {
        .payments-grid {
            grid-template-columns: 1fr;
        }
    }

    .page-header {
        margin-bottom: 36px;
    }

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
        margin-bottom: 28px;
    }

    .btn-gold {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: #C8916A;
        color: #1C1008;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-gold:hover { background: #AE7A55; }

    .payment-card {
        background: #FFFFFF;
        border-radius: 12px;
        border: 1px solid rgba(28,16,8,0.08);
        overflow: hidden;
        transition: border-color 0.2s;
    }

    .payment-card:hover { border-color: rgba(200,145,106,0.25); }

    .payment-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid rgba(28,16,8,0.06);
        flex-wrap: wrap;
        gap: 12px;
    }

    .payment-spa-name {
        font-size: 18px;
        font-weight: 600;
        color: #1C1008;
        font-family: 'Georgia', serif;
    }

    .payment-spa-loc {
        font-size: 13px;
        color: rgba(28,16,8,0.45);
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

    .status-paid     { background: rgba(67,160,71,0.15);  color: #6fcf72; border: 1px solid rgba(67,160,71,0.3); }
    .status-pending   { background: rgba(200,145,106,0.15); color: #C8916A; border: 1px solid rgba(200,145,106,0.3); }
    .status-failed    { background: rgba(229,57,53,0.12);  color: #ef9a9a; border: 1px solid rgba(229,57,53,0.3); }

    .payment-body {
        padding: 20px 24px;
    }

    .payment-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 18px;
    }

    .payment-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: rgba(28,16,8,0.65);
    }

    .payment-meta-item i { color: #C8916A; width: 14px; }

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
        background: rgba(28,16,8,0.04);
        border-radius: 6px;
        font-size: 13px;
        color: rgba(28,16,8,0.75);
    }

    .service-row .svc-price { color: #C8916A; font-weight: 600; }

    .payment-total {
        display: flex;
        justify-content: space-between;
        padding: 12px 14px;
        background: rgba(200,145,106,0.07);
        border: 1px solid rgba(200,145,106,0.15);
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        color: #1C1008;
    }

    .payment-total span { color: #C8916A; }

    .payment-footer {
        padding: 14px 24px;
        border-top: 1px solid rgba(28,16,8,0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        font-size: 13px;
        color: rgba(28,16,8,0.4);
    }

    .payment-footer-left,
    .payment-footer-right {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .receipt-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 14px;
        border-radius: 999px;
        border: 1px solid rgba(200,145,106,0.3);
        background: rgba(200,145,106,0.08);
        color: #A86F47;
        text-decoration: none;
        font-weight: 700;
        transition: background 0.2s, border-color 0.2s, color 0.2s;
    }

    .receipt-btn:hover {
        background: rgba(200,145,106,0.16);
        border-color: rgba(200,145,106,0.5);
        color: #8F5C38;
    }
</style>

<div class="payments-page">
    <div class="page-header">
        <h1><i class="fas fa-credit-card" style="color:#C8916A;font-size:26px;margin-right:10px;"></i> Payment History</h1>
        <p>Track all your transactions</p>
    </div>

    @if($payments->isEmpty())
        <div class="empty-state">
            <i class="fas fa-credit-card"></i>
            <h2>No Payments Yet</h2>
            <p>Your transaction history will appear here once you make a payment.</p>
            <a href="{{ route('customer.services') }}" class="btn-gold"><i class="fas fa-spa"></i> Browse Services</a>
        </div>
    @else
        <div class="payments-grid">
        @foreach($payments as $payment)
        <div class="payment-card">
            <div class="payment-header">
                <div>
                    @if($payment->booking && $payment->booking->spa)
                        <div class="payment-spa-name">{{ $payment->booking->spa->name }}</div>
                        <div class="payment-spa-loc"><i class="fas fa-map-marker-alt" style="color:#C8916A;"></i> {{ $payment->booking->spa->city }}</div>
                    @else
                        <div class="payment-spa-name">Payment #{{ $payment->id }}</div>
                    @endif
                </div>
                @php
                    $statusClass = match(strtolower($payment->status)) {
                        'paid', 'completed', 'success' => 'status-paid',
                        'pending' => 'status-pending',
                        default => 'status-failed',
                    };
                @endphp
                <span class="status-badge {{ $statusClass }}">{{ ucfirst($payment->status) }}</span>
            </div>

            <div class="payment-body">
                <div class="payment-meta">
                    <div class="payment-meta-item">
                        <i class="fas fa-calendar"></i>
                        {{ $payment->created_at->format('D, d M Y') }}
                    </div>
                    <div class="payment-meta-item">
                        <i class="fas fa-wallet"></i>
                        {{ $payment->method ?? 'N/A' }}
                    </div>
                    @if($payment->booking)
                        <div class="payment-meta-item">
                            <i class="fas fa-hashtag"></i>
                            Booking #{{ $payment->booking->id }}
                        </div>
                    @endif
                </div>

                @if($payment->booking && $payment->booking->bookingServices->count())
                    <div class="services-list">
                        @foreach($payment->booking->bookingServices as $bs)
                            <div class="service-row">
                                <span>{{ $bs->service_name }} <span style="color:rgba(28,16,8,0.35);">· {{ $bs->duration_minutes }} min</span></span>
                                <span class="svc-price">Rs. {{ number_format($bs->price, 0) }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="payment-total">
                    <span>Total Paid</span>
                    <span>Rs. {{ number_format($payment->amount, 0) }}</span>
                </div>
            </div>

            <div class="payment-footer">
                <div class="payment-footer-left">
                    @if($payment->transaction_id)
                        <span><i class="fas fa-receipt" style="margin-right:4px;"></i> TXN: {{ $payment->transaction_id }}</span>
                    @else
                        <span style="opacity:0.4;">No transaction ID</span>
                    @endif

                    <a href="{{ route('customer.payments.receipt', $payment) }}" class="receipt-btn">
                        <i class="fas fa-file-pdf"></i>
                        Download Receipt
                    </a>
                </div>

                <div class="payment-footer-right">
                    <span style="background:rgba(67,160,71,0.12);color:#6fcf72;border:1px solid rgba(67,160,71,0.3);padding:4px 12px;border-radius:12px;font-weight:600;">
                        <i class="fas fa-check-circle"></i> {{ ucfirst($payment->method ?? 'Paid') }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
        </div>
    @endif
</div>
@endsection
