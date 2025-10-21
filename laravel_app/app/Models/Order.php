<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'driver_id', 'car_id',
        'status', 'from_address', 'to_address',
        'distance', 'price', 'comment', 'scheduled_at',
        'car_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function histories()
    {
        return $this->hasMany(OrderHistory::class);
    }
}
