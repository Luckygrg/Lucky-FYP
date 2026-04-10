<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification
{

    public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $booking = $this->booking;

        return (new MailMessage)
            ->subject('Booking Confirmed - ' . $booking->spa->name)
            ->greeting('Great news, ' . $notifiable->name . '!')
            ->line('Your booking at **' . $booking->spa->name . '** has been confirmed by the spa owner.')
            ->line('**Date:** ' . $booking->booking_date->format('D, d M Y'))
            ->line('**Time:** ' . \Carbon\Carbon::parse($booking->booking_time)->format('h:i A'))
            ->line('**Services:** ' . $booking->bookingServices->pluck('service_name')->join(', '))
            ->line('**Duration:** ' . $booking->total_duration_minutes . ' minutes')
            ->line('**Total:** Rs. ' . number_format($booking->total_price, 0))
            ->line('**Payment:** ' . ($booking->payment_option === 'pay_now' ? 'Pay via eSewa' : 'Pay at Spa'))
            ->action('View My Bookings', route('customer.bookings'))
            ->line('Thank you for choosing SpaLush!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'spa_name' => $this->booking->spa->name,
            'booking_date' => $this->booking->booking_date->toDateString(),
            'booking_time' => $this->booking->booking_time,
            'total_price' => $this->booking->total_price,
            'message' => 'Your booking at ' . $this->booking->spa->name . ' has been confirmed!',
        ];
    }
}
