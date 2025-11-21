<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlacklistLog extends Model
{
    //
    protected $fillable = [
        'user_profile_id',
        'action',
        'reason',
        'performed_by'
    ];

    public function profile()
    {
        return $this->belongsTo(UserProfile::class, 'user_profile_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
