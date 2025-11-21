<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    protected $fillable=['title','cost','details','start_date','end_date','total_vouchers','business_id','remaining_vouchers','status','image'];
    
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

     public function business()
    {
        return $this->belongsTo(Business::class);
    }

    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_coupon');
    }

    public function suspensions()
    {
        return $this->hasMany(CouponSuspension::class);
    }

    public function systemCharge()
    {
        return SystemCharge::whereIn('cat_id', $this->categories->pluck('id'))
            ->first();
    }


}
