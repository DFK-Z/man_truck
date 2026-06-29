<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Truck extends Model
{
    protected $fillable = [
        'title', 'brand', 'year', 'price',
        'description', 'load_capacity', 'body_type', 'is_active'
    ];

    public function images()
    {
        return $this->hasMany(TruckImage::class);
    }

    public function mainImage()
    {
        return $this->hasOne(TruckImage::class)->where('is_main', true);
    }
}
