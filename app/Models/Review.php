<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'spa_id',
        'booking_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function spa()
    {
        return $this->belongsTo(Spa::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
