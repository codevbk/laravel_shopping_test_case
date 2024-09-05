<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'discount', 'discount_type', 'eligible_products'];

    public function applyDiscount($total)
    {
        if ($this->discount_type == 'fixed') {
            return max(0, $total - $this->discount);
        } elseif ($this->discount_type == 'percent') {
            return max(0, $total - ($total * ($this->discount / 100)));
        }
        return $total;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupon_product', 'coupon_id', 'product_id');
    }
}
