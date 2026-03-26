<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'spa_id',
        'phone',
        'booking_date',
        'booking_time',
        'total_duration_minutes',
        'total_price',
        'status',
        'payment_status',
        'payment_option',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price'  => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function spa()
    {
        return $this->belongsTo(Spa::class);
    }

    public function bookingServices()
    {
        return $this->hasMany(BookingService::class);
    }
}
