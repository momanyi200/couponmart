<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingStage extends Model
{
    //
        protected $fillable = [
        'stage_name', 'stage_number', 'completed', 'completed_at'
    ];

    public function onboardable()
    {
        return $this->morphTo();
    }
}
