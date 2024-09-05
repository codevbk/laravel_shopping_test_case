<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coupon_product')->insert([
            [
                'coupon_id' => 3,  
                'product_id' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 3,  
                'product_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 4,
                'product_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 4,
                'product_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
