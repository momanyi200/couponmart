<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CouponExpiryReminderNotification;

class CouponExpiryReminder extends Command
{
    protected $signature = 'coupons:remind-expiry';
    protected $description = 'Send reminders for coupons expiring in 3 days';

    public function handle(): int
    {
        $reminderDate = Carbon::today()->addDays(3);

        $coupons = Coupon::where('status', 'active')
            ->whereDate('end_date', '=', $reminderDate)
            ->get();

        foreach ($coupons as $coupon) {
            // Notify business owner
            $businessOwner = $coupon->business->owner ?? null;
            if ($businessOwner) {
                Notification::send($businessOwner, new CouponExpiryReminderNotification($coupon));
            }

            // Notify customers
            $customers = $coupon->redemptions()->with('user')->get()->pluck('user')->filter();
            if ($customers->isNotEmpty()) {
                Notification::send($customers, new CouponExpiryReminderNotification($coupon));
            }
        }

        $this->info($coupons->count() . ' coupon reminder(s) sent.');
        return Command::SUCCESS;
    }
}
