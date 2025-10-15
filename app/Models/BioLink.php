<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BioLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'bio_page_id', 'label', 'url', 'type', 'icon', 'sort_order', 'is_active'
    ];

    public function getIconClassAttribute(): string
    {
        return match($this->type) {
            'instagram' => 'fa-brands fa-instagram',
            'whatsapp' => 'fa-brands fa-whatsapp',
            'youtube' => 'fa-brands fa-youtube',
            'tiktok' => 'fa-brands fa-tiktok',
            'website' => 'fa-solid fa-globe',
            default => 'fa-solid fa-link',
        };
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(BioPage::class, 'bio_page_id');
    }
}


