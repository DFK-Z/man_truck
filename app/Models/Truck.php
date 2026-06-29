<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Truck extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'price',
        'image',
        'description',
        'engine',
        'transmission',
        'mileage',
        'is_available',
        'views'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'year' => 'integer',
        'is_available' => 'boolean'
    ];

    // Аксессор для форматирования цены
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' ₽';
    }
}
