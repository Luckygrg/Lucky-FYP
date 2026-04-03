<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #FAF7F2 0%, #F5EEE4 100%);
            padding: 40px 30px;
            text-align: center;
            border-bottom: 3px solid #C8916A;
        }
        .email-header h1 {
            color: #C8916A;
            margin: 0 0 8px;
            font-size: 28px;
            font-weight: 300;
            letter-spacing: 3px;
            font-family: Georgia, serif;
        }
        .email-header .confirmed-badge {
            display: inline-block;
            background: rgba(67,160,71,0.12);
            color: #2e7d32;
            border: 1px solid rgba(67,160,71,0.4);
            padding: 5px 18px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .email-body {
            padding: 36px 30px;
        }
        .email-body h2 {
            color: #1C1008;
            font-size: 22px;
            margin-bottom: 12px;
            font-family: Georgia, serif;
            font-weight: 400;
        }
        .email-body p {
            color: #555;
            font-size: 15px;
            margin-bottom: 16px;
        }
        .booking-details {
            background: #FAF7F2;
            border: 1px solid rgba(200,145,106,0.2);
            border-radius: 8px;
            padding: 20px 24px;
            margin: 24px 0;
        }
        .booking-details h3 {
            color: #C8916A;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 16px;
            font-family: Georgia, serif;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(200,145,106,0.1);
            font-size: 14px;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #999; }
        .detail-value { color: #1C1008; font-weight: 600; }
        .payment-section {
            margin: 24px 0;
        }
        .payment-section p {
            font-size: 15px;
            color: #444;
            margin-bottom: 16px;
        }
        .payment-options {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .btn-esewa {
            display: inline-block;
            padding: 12px 28px;
            background: #C8916A;
            color: #1C1008 !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.5px;
        }
        .btn-spa {
            display: inline-block;
            padding: 12px 28px;
            background: transparent;
            color: #C8916A !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            border: 2px solid #C8916A;
            letter-spacing: 0.5px;
        }
        .info-box {
            background: rgba(200,145,106,0.08);
            border-left: 4px solid #C8916A;
            padding: 14px 18px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .info-box p {
            margin: 0;
            color: #7A4F2D;
            font-size: 14px;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 28px 30px;
            text-align: center;
            border-top: 1px solid #e8e8e8;
        }
        .email-footer p {
            color: #999;
            font-size: 13px;
            margin: 4px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">

        <div class="email-header">
            <h1>SPALUSH</h1>
            <span class="confirmed-badge">✓ Booking Confirmed</span>
        </div>

        <div class="email-body">
            <h2>Great news, {{ $booking->customer->name }}!</h2>
            <p>Your booking at <strong>{{ $booking->spa->name }}</strong> has been approved by the spa owner. You can now proceed with your payment.</p>

            <div class="booking-details">
                <h3>Booking Summary</h3>
                <div class="detail-row">
                    <span class="detail-label">Spa</span>
                    <span class="detail-value">{{ $booking->spa->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date</span>
                    <span class="detail-value">{{ $booking->booking_date->format('D, d M Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Time</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Services</span>
                    <span class="detail-value">{{ $booking->bookingServices->pluck('service_name')->join(', ') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Duration</span>
                    <span class="detail-value">{{ $booking->total_duration_minutes }} minutes</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount</span>
                    <span class="detail-value">Rs. {{ number_format($booking->total_price, 0) }}</span>
                </div>
            </div>

            <div class="payment-section">
                <p><strong>Choose your payment method:</strong></p>
                <div class="payment-options">
                    <a href="{{ route('customer.bookings') }}" class="btn-esewa">Pay via eSewa</a>
                    <a href="{{ route('customer.bookings') }}" class="btn-spa">Pay at the Spa</a>
                </div>
            </div>

            <div class="info-box">
                <p>You can also manage your payment anytime from your <strong>My Bookings</strong> page on SpaLush.</p>
            </div>

            <p style="color:#999;font-size:13px;margin-top:28px;">
                If you have any questions, feel free to contact the spa directly.
            </p>
        </div>

        <div class="email-footer">
            <p><strong>SpaLush</strong> - Your Premier Spa Booking Platform</p>
            <p>&copy; {{ date('Y') }} SpaLush. All rights reserved.</p>
        </div>

    </div>
</body>
</html>
