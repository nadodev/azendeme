<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoyaltyReward extends Model
{
    protected $fillable = [
        'professional_id',
        'name',
        'description',
        'points_required',
        'reward_type',
        'discount_value',
        'free_service_id',
        'active',
        'max_redemptions',
        'current_redemptions',
        'valid_from',
        'valid_until',
    ];

    protected $casts = [
        'active' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'discount_value' => 'decimal:2',
    ];

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }
}
