<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_product');
    }
}
