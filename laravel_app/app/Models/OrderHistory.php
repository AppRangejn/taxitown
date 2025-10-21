<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['order_id', 'status', 'changed_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
