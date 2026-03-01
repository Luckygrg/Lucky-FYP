<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'location',
        'city',
        'description',
        'image',
        'price_range',
        'is_featured',
        'rating',
        'review_count',
        'tags',
        'phone',
        'email',
        'opening_hours',
        'is_active',
        'status',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'decimal:1',
    ];

    /**
     * Get the spa owner (user) that owns the spa
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the services offered by this spa
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
