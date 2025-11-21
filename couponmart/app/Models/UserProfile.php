<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    //

    protected $fillable = [
        'first_name',
        'last_name',
        'image',
        'user_id',
        'phone_number',
        'town_id',
        'gender',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    } 

    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    public function blacklistLogs()
    {
        return $this->hasMany(BlacklistLog::class);
    }


}
