<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Всі замовлення користувача
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Всі рейтинги користувача
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Всі сповіщення користувача
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
