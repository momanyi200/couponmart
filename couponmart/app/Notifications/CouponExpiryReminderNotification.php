<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CouponExpiryReminderNotification extends Notification
{
    use Queueable;
    protected $coupon;

    public function __construct($coupon)
    {
        $this->coupon = $coupon;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Coupon Expiry Reminder')
            ->line("The coupon '{$this->coupon->title}' will expire on {$this->coupon->end_date}.")
            ->line('You have 3 days left to use or promote it.')
            ->action('View Coupon', url('/coupons/'.$this->coupon->id));
    }

    public function toArray($notifiable)
    {
        return [
            'coupon_id' => $this->coupon->id,
            'title' => $this->coupon->title,
            'expires_in_days' => 3
        ];
    }
}
