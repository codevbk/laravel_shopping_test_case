<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coupon_user')->insert([
            [
                'coupon_id' => 1,  
                'user_id' => 1, 
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 2,  
                'user_id' => 1,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 3,  
                'user_id' => 1,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 4,  
                'user_id' => 1,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 5,  
                'user_id' => 1,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 6,  
                'user_id' => 1,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 7,  
                'user_id' => 1,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 8,  
                'user_id' => 1,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 1,  
                'user_id' => 2, 
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 2,  
                'user_id' => 2,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 3,  
                'user_id' => 2,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 4,  
                'user_id' => 1,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 5,  
                'user_id' => 2,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 6,  
                'user_id' => 2,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 7,  
                'user_id' => 2,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coupon_id' => 8,  
                'user_id' => 2,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
