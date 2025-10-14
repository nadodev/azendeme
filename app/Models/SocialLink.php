<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialLink extends Model
{
    protected $fillable = [
        'professional_id',
        'platform',
        'url',
        'show_booking_button',
        'active',
        'click_count',
    ];

    protected $casts = [
        'active' => 'boolean',
        'show_booking_button' => 'boolean',
    ];

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }
}
