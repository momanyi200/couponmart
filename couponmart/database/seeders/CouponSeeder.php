<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use App\Models\Business;

class CouponSeeder extends Seeder
{
    public function run()
    {
        $business = Business::first();

        Coupon::create([
            'title' => '50% Off Fashion Items',
            'business_id' => $business->id,
            'cost' => 100,
            'details' => 'Get 50% discount on all fashion items from Quick Deals.',
            'start_date' => now(),
            'end_date' => now()->addDays(10),
            'total_vouchers' => 100,
            'remaining_vouchers' => 100,
            'image' => null,
            'total_view' => 0,
            'status' => 'active',
            'system_charges' => 10,
        ]);
    }
}

