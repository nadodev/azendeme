<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyProgram extends Model
{
    protected $fillable = [
        'professional_id',
        'name',
        'description',
        'active',
        'points_per_visit',
        'points_per_currency',
        'points_expiry_days',
    ];

    protected $casts = [
        'active' => 'boolean',
        'points_per_currency' => 'decimal:2',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function rewards()
    {
        return $this->hasMany(LoyaltyReward::class, 'professional_id', 'professional_id');
    }
}
