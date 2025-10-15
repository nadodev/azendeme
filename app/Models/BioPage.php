<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BioPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'slug',
        'title',
        'description',
        'avatar_path',
        'whatsapp_number',
        'instagram_url',
        'facebook_url',
        'twitter_url',
        'youtube_url',
        'tiktok_url',
        'linkedin_url',
        'theme_color',
        'background_color',
        'button_color',
        'theme',
        'enable_booking',
        'is_active',
    ];

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(BioLink::class)->orderBy('sort_order');
    }
}


