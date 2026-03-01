<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'spa_id',
        'name',
        'description',
        'price',
        'duration_minutes',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function spa()
    {
        return $this->belongsTo(Spa::class);
    }
}
