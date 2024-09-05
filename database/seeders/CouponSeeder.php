<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coupons')->insert([
            [
                'code' => 'fixed_total_amount_discount',
                'discount' => 10.00,
                'type' => 'total',         // 'total', 'eligible', 'equal', 'tax'
                'discount_type' => 'fixed', // 'fixed', 'percent'
                'expired_at' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'percent_total_amount_discount',
                'discount' => 5.00,
                'type' => 'total',         // 'total', 'eligible', 'equal', 'tax'
                'discount_type' => 'percent', // 'fixed', 'percent'
                'expired_at' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'fixed_eligible_product_1_2_discount',
                'discount' => 10.00,
                'type' => 'eligible',         // 'total', 'eligible', 'equal', 'tax'
                'discount_type' => 'fixed', // 'fixed', 'percent'
                'expired_at' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'percent_eligible_product_1_2_discount',
                'discount' => 5.00,
                'type' => 'eligible',         // 'total', 'eligible', 'equal', 'tax'
                'discount_type' => 'percent', // 'fixed', 'percent'
                'expired_at' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'fixed_x_amount_equally_discount',
                'discount' => 10.00,
                'type' => 'equal',         // 'total', 'eligible', 'equal', 'tax'
                'discount_type' => 'fixed', // 'fixed', 'percent'
                'expired_at' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'percent_x_amount_equally_discount',
                'discount' => 5.00,
                'type' => 'equal',         // 'total', 'eligible', 'equal', 'tax'
                'discount_type' => 'percent', // 'fixed', 'percent'
                'expired_at' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'percent_taxes_amount_discount',
                'discount' => 20.00,
                'type' => 'tax',         // 'total', 'eligible', 'equal', 'tax'
                'discount_type' => 'percent', // 'fixed', 'percent'
                'expired_at' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'fixed_required_product_1_total_amount_discount',
                'discount' => 20.00,
                'type' => 'required',         // 'total', 'eligible', 'equal', 'tax'
                'discount_type' => 'fixed', // 'fixed', 'percent'
                'expired_at' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
