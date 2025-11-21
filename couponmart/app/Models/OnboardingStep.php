<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingStep extends Model
{
    //
     protected $fillable = [
        'onboardable_id',
        'onboardable_type',
        'step_order',
        'status',
        'step_name',
        'meta',
        'completed_at'
    ];

    public function onboardable()
    {
        return $this->morphTo();
    }

    protected $casts = [
        'meta' => 'array',
    ];
   
}

