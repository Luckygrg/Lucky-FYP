<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessfulNotification extends Notification
{
    public function __construct(
        public Booking $booking,
        public Payment $payment,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment Successful - ' . $this->booking->spa->name)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your payment for **' . $this->booking->spa->name . '** was completed successfully.')
            ->line('**Amount Paid:** Rs. ' . number_format($this->payment->amount, 2))
            ->line('**Payment Method:** ' . strtoupper($this->payment->method))
            ->line('**Transaction ID:** ' . $this->payment->transaction_id)
            ->action('View Payment History', route('customer.payments'))
            ->line('Thank you for completing your payment with SpaLush.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'payment_id' => $this->payment->id,
            'spa_name' => $this->booking->spa->name,
            'amount' => $this->payment->amount,
            'transaction_id' => $this->payment->transaction_id,
            'method' => $this->payment->method,
            'message' => 'Your payment for ' . $this->booking->spa->name . ' was successful.',
        ];
    }
}