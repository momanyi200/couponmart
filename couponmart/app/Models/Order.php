<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    
     // App\Models\Order.php
    protected $fillable = [
        'user_id','order_number','total','qr_code_path','seller_id',
        'status',
        'redeemed_by',
        'redeemed_at',
        'qr_active',
        'paid_via_wallet',
        'paid_amount',
    ];


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

   
}
