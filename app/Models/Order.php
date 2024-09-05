<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_id', 'subtotal', 'taxes', 'total', 'coupon_id', 'discount', 'subtotal_after_discount', 'taxes_after_discount', 'total_after_discount', 'status'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_id = (string) Str::uuid();
        });
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')
                    ->withPivot('quantity', 'price');
    }
}
