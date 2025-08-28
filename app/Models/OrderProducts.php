<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;

class OrderProducts extends Model
{
    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
