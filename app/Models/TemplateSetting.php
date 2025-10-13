<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'primary_color',
        'secondary_color',
        'accent_color',
        'background_color',
        'text_color',
        'hero_title',
        'hero_subtitle',
        'hero_badge',
        'services_title',
        'services_subtitle',
        'gallery_title',
        'gallery_subtitle',
        'contact_title',
        'contact_subtitle',
        'show_hero_badge',
        'show_dividers',
        'button_style',
    ];

    protected $casts = [
        'show_hero_badge' => 'boolean',
        'show_dividers' => 'boolean',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
