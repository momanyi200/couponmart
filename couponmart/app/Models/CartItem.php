<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //
     protected $fillable = ['user_id', 'coupon_id', 'quantity', 'price'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
