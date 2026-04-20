<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #2F241C;
            margin: 0;
            padding: 32px;
            background: #FFFDF9;
            font-size: 13px;
            line-height: 1.5;
        }

        .receipt {
            border: 1px solid #E6D7C8;
            border-radius: 16px;
            padding: 28px;
            background: #FFFFFF;
        }

        .header {
            border-bottom: 2px solid #EADBCB;
            padding-bottom: 18px;
            margin-bottom: 24px;
        }

        .brand {
            font-size: 26px;
            font-weight: 700;
            color: #A86F47;
            margin: 0 0 4px;
        }

        .subtitle {
            color: #7B6656;
            margin: 0;
        }

        .receipt-meta {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .receipt-meta td {
            width: 50%;
            padding: 8px 0;
            vertical-align: top;
        }

        .label {
            display: block;
            color: #9A8575;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 3px;
        }

        .value {
            font-size: 14px;
            font-weight: 600;
            color: #2F241C;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #A86F47;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin: 24px 0 12px;
        }

        table.services {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.services th,
        table.services td {
            border-bottom: 1px solid #F0E6DC;
            padding: 12px 0;
            text-align: left;
        }

        table.services th:last-child,
        table.services td:last-child {
            text-align: right;
        }

        .total-box {
            margin-top: 10px;
            margin-left: auto;
            width: 260px;
            border: 1px solid #E6D7C8;
            border-radius: 12px;
            padding: 14px 16px;
            background: #FFF8F2;
        }

        .total-row {
            overflow: hidden;
        }

        .total-row span:first-child {
            float: left;
            font-weight: 700;
        }

        .total-row span:last-child {
            float: right;
            font-weight: 700;
            color: #A86F47;
        }

        .footer {
            margin-top: 28px;
            padding-top: 16px;
            border-top: 1px solid #F0E6DC;
            color: #8B7667;
            font-size: 12px;
        }

        .status-pill {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #E8F6E8;
            color: #3E8B42;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <p class="brand">SpaLush</p>
            <p class="subtitle">Payment receipt for your spa booking</p>
        </div>

        <table class="receipt-meta">
            <tr>
                <td>
                    <span class="label">Receipt For</span>
                    <span class="value">{{ $payment->user?->name ?? 'Customer' }}</span>
                </td>
                <td>
                    <span class="label">Receipt Date</span>
                    <span class="value">{{ $payment->paid_at?->format('d M Y, h:i A') ?? $payment->created_at->format('d M Y, h:i A') }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">Spa</span>
                    <span class="value">{{ $payment->booking?->spa?->name ?? 'SpaLush Partner Spa' }}</span>
                </td>
                <td>
                    <span class="label">Payment Status</span>
                    <span class="status-pill">{{ ucfirst($payment->status) }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">Payment Method</span>
                    <span class="value">{{ $payment->method ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="label">Transaction ID</span>
                    <span class="value">{{ $payment->transaction_id ?? 'N/A' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">Booking ID</span>
                    <span class="value">{{ $payment->booking?->id ? '#'.$payment->booking->id : 'N/A' }}</span>
                </td>
                <td>
                    <span class="label">Booked Slot</span>
                    <span class="value">
                        @if($payment->booking?->booking_date && $payment->booking?->booking_time)
                            {{ $payment->booking->booking_date->format('d M Y') }}, {{ \Illuminate\Support\Carbon::parse($payment->booking->booking_time)->format('h:i A') }}
                        @else
                            N/A
                        @endif
                    </span>
                </td>
            </tr>
        </table>

        <div class="section-title">Services</div>
        <table class="services">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Duration</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payment->booking?->bookingServices ?? [] as $service)
                    <tr>
                        <td>{{ $service->service_name }}</td>
                        <td>{{ $service->duration_minutes }} min</td>
                        <td>Rs. {{ number_format($service->price, 0) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No service details available for this payment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="total-box">
            <div class="total-row">
                <span>Total Paid</span>
                <span>Rs. {{ number_format($payment->amount, 0) }}</span>
            </div>
        </div>

        <div class="footer">
            This receipt was generated automatically by SpaLush on {{ now()->format('d M Y, h:i A') }}.
        </div>
    </div>
</body>
</html>