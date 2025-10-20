<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'experience_years',
        'photo',
        'status',
        'car_type', // economy / comfort / luxe
    ];

    // Водій має одне авто
    public function car()
    {
        return $this->hasOne(Car::class);
    }

    // Водій має багато замовлень
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Водій має рейтинги
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Середній рейтинг водія
    public function averageRating(): float
    {
        return $this->ratings()->avg('score') ?? 0;
    }
}
