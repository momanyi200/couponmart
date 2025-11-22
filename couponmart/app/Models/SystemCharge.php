<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemCharge extends Model
{
    protected $fillable = [
        'cat_id',
        'percentage',
        'cashback_percentage',
        'added_by',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}

