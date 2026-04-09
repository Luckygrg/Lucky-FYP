<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f4f4f4; margin: 0; padding: 0;">

    {{-- Outer wrapper --}}
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f4; padding: 40px 0;">
        <tr>
            <td align="center">

                {{-- Main container --}}
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">

                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #FAF7F2 0%, #F5EEE4 100%); padding: 44px 30px 36px; text-align: center; border-bottom: 3px solid #C8916A;">
                            <h1 style="color: #C8916A; margin: 0 0 16px; font-size: 30px; font-weight: 300; letter-spacing: 4px; font-family: Georgia, serif;">SPALUSH</h1>
                            <table cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td style="background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; padding: 6px 22px; border-radius: 20px; font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;">
                                        &#10003; Payment Successful
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 40px 36px;">

                            {{-- Greeting --}}
                            <h2 style="color: #1C1008; font-size: 22px; margin: 0 0 10px; font-family: Georgia, serif; font-weight: 400;">Thank you, {{ $booking->customer->name }}!</h2>
                            <p style="color: #666; font-size: 15px; margin: 0 0 30px;">Your payment for the booking at <strong style="color: #333;">{{ $booking->spa->name }}</strong> has been received successfully. Here's your receipt.</p>

                            {{-- Booking Details --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #FAF7F2; border: 1px solid #f0e0d0; border-radius: 10px; margin-bottom: 28px;">
                                <tr>
                                    <td style="padding: 22px 26px 6px;">
                                        <h3 style="color: #C8916A; font-size: 12px; text-transform: uppercase; letter-spacing: 2px; margin: 0 0 18px; font-family: Georgia, serif; font-weight: 700;">Booking Details</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 26px 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #eedcc8; color: #999; font-size: 14px; width: 40%;">Spa</td>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #eedcc8; color: #1C1008; font-size: 14px; font-weight: 600; text-align: right;">{{ $booking->spa->name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #eedcc8; color: #999; font-size: 14px;">Date</td>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #eedcc8; color: #1C1008; font-size: 14px; font-weight: 600; text-align: right;">{{ $booking->booking_date->format('D, d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #eedcc8; color: #999; font-size: 14px;">Time</td>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #eedcc8; color: #1C1008; font-size: 14px; font-weight: 600; text-align: right;">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; color: #999; font-size: 14px;">Duration</td>
                                                <td style="padding: 10px 0; color: #1C1008; font-size: 14px; font-weight: 600; text-align: right;">{{ $booking->total_duration_minutes }} minutes</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- Services Bill --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #f0e0d0; border-radius: 10px; margin-bottom: 8px; overflow: hidden;">
                                <tr>
                                    <td style="background: #FAF7F2; padding: 12px 16px; color: #C8916A; font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; border-bottom: 2px solid #eedcc8; width: 45%;">Service</td>
                                    <td style="background: #FAF7F2; padding: 12px 16px; color: #C8916A; font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; border-bottom: 2px solid #eedcc8; text-align: center; width: 25%;">Duration</td>
                                    <td style="background: #FAF7F2; padding: 12px 16px; color: #C8916A; font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; border-bottom: 2px solid #eedcc8; text-align: right; width: 30%;">Price</td>
                                </tr>
                                @foreach ($booking->bookingServices as $item)
                                <tr>
                                    <td style="padding: 12px 16px; font-size: 14px; color: #333; border-bottom: 1px solid #f5ebe0;">{{ $item->service_name }}</td>
                                    <td style="padding: 12px 16px; font-size: 14px; color: #666; border-bottom: 1px solid #f5ebe0; text-align: center;">{{ $item->duration_minutes }} min</td>
                                    <td style="padding: 12px 16px; font-size: 14px; color: #333; border-bottom: 1px solid #f5ebe0; text-align: right; font-weight: 600;">Rs. {{ number_format($item->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>

                            {{-- Total --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%); border: 1px solid #c8e6c9; border-radius: 10px; margin-bottom: 28px;">
                                <tr>
                                    <td style="padding: 18px 26px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="font-size: 16px; color: #1C1008; font-weight: 600;">Total Paid</td>
                                                <td style="font-size: 24px; color: #2e7d32; font-weight: 700; text-align: right; font-family: Georgia, serif;">Rs. {{ number_format($booking->total_price, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- Payment Info --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #f6fdf6; border: 1px solid #c8e6c9; border-radius: 10px; margin-bottom: 28px;">
                                <tr>
                                    <td style="padding: 22px 26px 6px;">
                                        <h3 style="color: #2e7d32; font-size: 12px; text-transform: uppercase; letter-spacing: 2px; margin: 0 0 18px; font-family: Georgia, serif; font-weight: 700;">Payment Information</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 26px 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #dcedc8; color: #999; font-size: 14px; width: 40%;">Payment Method</td>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #dcedc8; color: #1C1008; font-size: 14px; font-weight: 600; text-align: right;">eSewa</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #dcedc8; color: #999; font-size: 14px;">Transaction ID</td>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #dcedc8; color: #1C1008; font-size: 14px; font-weight: 600; text-align: right; font-family: monospace;">{{ $payment->transaction_id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #dcedc8; color: #999; font-size: 14px;">Paid At</td>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #dcedc8; color: #1C1008; font-size: 14px; font-weight: 600; text-align: right;">{{ $payment->paid_at->format('d M Y, h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; color: #999; font-size: 14px;">Status</td>
                                                <td style="padding: 10px 0; color: #2e7d32; font-size: 14px; font-weight: 700; text-align: right;">&#10003; Completed</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- Info Box --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
                                <tr>
                                    <td style="background: #fdf5ee; border-left: 4px solid #C8916A; padding: 16px 20px; border-radius: 0 6px 6px 0;">
                                        <p style="margin: 0; color: #7A4F2D; font-size: 14px; line-height: 1.5;">Please keep this email as your payment receipt. Present it at the spa on your appointment date.</p>
                                    </td>
                                </tr>
                            </table>

                            {{-- CTA Button --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding: 8px 0 20px;">
                                        <a href="{{ route('customer.bookings') }}" style="display: inline-block; padding: 14px 36px; background: #C8916A; color: #ffffff !important; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px; letter-spacing: 0.5px;">View My Bookings</a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #aaa; font-size: 13px; margin: 10px 0 0; text-align: center;">
                                If you have any questions, feel free to contact the spa directly.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background: #fafafa; padding: 28px 30px; text-align: center; border-top: 1px solid #eee;">
                            <p style="color: #888; font-size: 13px; margin: 0 0 4px;"><strong style="color: #666;">SpaLush</strong> &mdash; Your Premier Spa Booking Platform</p>
                            <p style="color: #aaa; font-size: 12px; margin: 0;">&copy; {{ date('Y') }} SpaLush. All rights reserved.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
