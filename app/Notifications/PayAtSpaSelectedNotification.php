<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayAtSpaSelectedNotification extends Notification
{
    public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pay at Spa Selected - ' . $this->booking->spa->name)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You selected **Pay at Spa** for your booking at **' . $this->booking->spa->name . '**.')
            ->line('**Booking Date:** ' . $this->booking->booking_date->format('D, d M Y'))
            ->line('**Time:** ' . \Carbon\Carbon::parse($this->booking->booking_time)->format('h:i A'))
            ->line('**Amount Due:** Rs. ' . number_format($this->booking->total_price, 2))
            ->action('View My Bookings', route('customer.bookings'))
            ->line('Please pay at the spa when you arrive for your appointment.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'spa_name' => $this->booking->spa->name,
            'booking_date' => $this->booking->booking_date->toDateString(),
            'booking_time' => $this->booking->booking_time,
            'total_price' => $this->booking->total_price,
            'message' => 'You selected Pay at Spa for your booking at ' . $this->booking->spa->name . '.',
        ];
    }
}