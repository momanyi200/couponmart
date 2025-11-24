<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Business; 
use App\Models\Conversation;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        //'account_type', // Added for role-based account type
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function onboardingStages()
    {
        return $this->morphMany(\App\Models\OnboardingStage::class, 'onboardable');
    }

    public function business()
    {
        return $this->hasOne(Business::class);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function wallet() 
    {
        return $this->hasOne(Wallet::class);
    }

    public function getWalletBalanceAttribute()
    {
        return $this->wallet->balance ?? 0;
    }

    public function conversations()
    {
        // assuming you are using a pivot table conversation_participants
        return $this->belongsToMany(
            Conversation::class, 
            'conversation_participants', 
            'user_id', 
            'conversation_id'
        )->withTimestamps();
    }

    

}
