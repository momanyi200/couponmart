<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\ExpireCoupons;
use App\Console\Commands\CouponExpiryReminder;


// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');


// * * * * * php /path/to/your/project/artisan schedule:run >> /dev/null 2>&1



Schedule::command(ExpireCoupons::class)->dailyAt('00:10');
Schedule::command(CouponExpiryReminder::class)->dailyAt('00:20');
