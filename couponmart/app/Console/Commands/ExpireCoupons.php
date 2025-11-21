<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CouponExpiredNotification;

class ExpireCoupons extends Command
{
    protected $signature = 'coupons:expire';
    protected $description = 'Mark expired coupons and notify owners & customers';

    public function handle(): int
    {
        $expiredCoupons = Coupon::where('status', 'active')
            ->whereDate('end_date', '<', Carbon::today())
            ->get();

        foreach ($expiredCoupons as $coupon) {
            $coupon->update(['status' => 'expired']);

            // Notify business owner
            $businessOwner = $coupon->business->owner ?? null;
            if ($businessOwner) {
                Notification::send($businessOwner, new CouponExpiredNotification($coupon));
            }

            // Notify customers
            $customers = $coupon->redemptions()->with('user')->get()->pluck('user')->filter();
            if ($customers->isNotEmpty()) {
                Notification::send($customers, new CouponExpiredNotification($coupon));
            }
        }

        $this->info($expiredCoupons->count() . ' coupon(s) expired.');
        return Command::SUCCESS;
    }
}
