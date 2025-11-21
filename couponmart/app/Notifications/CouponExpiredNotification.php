<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CouponExpiredNotification extends Notification
{
    use Queueable;
    protected $coupon;

    public function __construct($coupon)
    {
        $this->coupon = $coupon;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // can also add sms, slack, etc.
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Coupon Expired')
            ->line("The coupon '{$this->coupon->title}' has expired.")
            ->line('End Date: ' . $this->coupon->end_date)
            ->action('View Coupons', url('/coupons'));
    }

    public function toArray($notifiable)
    {
        return [
            'coupon_id' => $this->coupon->id,
            'title' => $this->coupon->title,
            'status' => 'expired',
        ];
    }
}

