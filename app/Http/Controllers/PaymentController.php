<?php

namespace App\Http\Controllers;

use App\Mail\PaymentSuccessful;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Xentixar\EsewaSdk\Esewa;

class PaymentController extends Controller
{
    /**
     * Customer explicitly chooses to pay at spa.
     */
    public function choosePayAtSpa(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'confirmed' || $booking->payment_status === 'paid') {
            return redirect()->route('customer.bookings')
                ->with('info', 'This booking is not eligible for payment selection.');
        }

        $booking->update([
            'payment_option' => 'pay_later',
            'payment_choice_made' => true,
        ]);

        return redirect()->route('customer.bookings')
            ->with('success', 'Payment option selected: Pay at Spa.');
    }

    /**
     * Initiate eSewa payment for a booking.
     */
    public function pay(Booking $booking)
    {
        // Only the booking owner can pay
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Only confirmed bookings that are still unpaid can pay via eSewa
        if ($booking->status !== 'confirmed' || $booking->payment_status === 'paid') {
            return redirect()->route('customer.bookings')
                ->with('info', 'This booking is not eligible for online payment.');
        }

        // Mark explicit customer choice before redirecting to gateway.
        $booking->update([
            'payment_option' => 'pay_now',
            'payment_choice_made' => true,
        ]);

        $transaction_uuid = strtoupper(bin2hex(random_bytes(10)));

        // Store identifiers in session to verify on callback
        session([
            'esewa_booking_id'       => $booking->id,
            'esewa_transaction_uuid' => $transaction_uuid,
        ]);

        $esewa = new Esewa();
        $esewa->config(
            route('esewa.check'),           // success URL
            route('esewa.check'),           // failure URL
            (float) $booking->total_price,
            $transaction_uuid
        );
        $esewa->init(); // auto-submits form to eSewa gateway
    }

    /**
     * Handle eSewa callback after payment (both success and failure).
     */
    public function check(Request $request)
    {
        $esewa = new Esewa();
        $data  = $esewa->decode(); // decodes ?data=<base64> from eSewa redirect

        $bookingId = session('esewa_booking_id');

        if (! $data || ! $bookingId) {
            return redirect()->route('customer.bookings')
                ->with('error', 'Payment verification failed. Please contact support.');
        }

        $booking = Booking::with('spa')->find($bookingId);

        if (! $booking || $booking->user_id !== Auth::id()) {
            return redirect()->route('customer.bookings')
                ->with('error', 'Invalid booking reference. Please contact support.');
        }

        // Check status returned in callback data (base64-decoded from eSewa redirect)
        if (($data['status'] ?? '') !== 'COMPLETE') {
            session()->forget(['esewa_booking_id', 'esewa_transaction_uuid']);

            return redirect()->route('customer.bookings')
                ->with('error', 'eSewa payment was not completed. You can choose to pay at the spa instead.');
        }

        $transactionId = $data['transaction_code'] ?? $data['transaction_uuid'];

        DB::transaction(function () use ($booking, $data, $transactionId) {
            $payment = Payment::create([
                'booking_id'     => $booking->id,
                'user_id'        => $booking->user_id,
                'amount'         => $booking->total_price,
                'method'         => 'esewa',
                'status'         => 'completed',
                'transaction_id' => $transactionId,
                'paid_at'        => now(),
            ]);

            $booking->update(['payment_status' => 'paid']);

            $booking->load(['customer', 'spa', 'bookingServices']);

            Mail::to($booking->customer->email)
                ->send(new PaymentSuccessful($booking, $payment));
        });

        session()->forget(['esewa_booking_id', 'esewa_transaction_uuid']);

        return redirect()->route('customer.bookings')
            ->with('success', 'Payment of Rs. ' . number_format($booking->total_price, 2) . ' via eSewa was successful! Transaction ID: ' . $transactionId);
    }
}
