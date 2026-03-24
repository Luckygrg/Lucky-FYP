<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SpaCategory extends Model
{
    protected $fillable = ['name'];

    public function spas()
    {
        return $this->hasMany(Spa::class);
    }
}
