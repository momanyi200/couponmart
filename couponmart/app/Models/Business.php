<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    //
    protected $fillable=['user_id','business_name','contact_name','phone_number','town_id','bios','image','location','room','floor','status','verified'];

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'business_category');
    }

   
    // In Customer.php, Staff.php, Vendor.php, etc.
    public function onboardingSteps()
    {
        return $this->morphMany(OnboardingStep::class, 'onboardable');
    }

    public function town(){
        return $this->belongsTo(Town::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
