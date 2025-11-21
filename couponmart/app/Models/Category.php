<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['cat_name'];

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'category_coupon');
    }

}
