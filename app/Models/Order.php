<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderStatus;
use App\Models\OrderProducts;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = [
        'user_id',
        'status_id',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function products()
    {
        return $this->hasMany(OrderProducts::class);
    }
}
