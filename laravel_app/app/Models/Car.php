<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'plate_number',
        'color',
        'driver_id',
    ];

    // Авто належить водію
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    // Авто може мати багато замовлень
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
