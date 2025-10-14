<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'page_type',
        'title',
        'description',
        'keywords',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'custom_head',
        'custom_footer',
        'canonical_url',
        'noindex',
        'nofollow',
    ];

    protected $casts = [
        'noindex' => 'boolean',
        'nofollow' => 'boolean',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Get SEO settings for a specific page type
     */
    public static function getForPage($professionalId, $pageType = 'home')
    {
        return static::where('professional_id', $professionalId)
                    ->where('page_type', $pageType)
                    ->first();
    }

    /**
     * Get or create SEO settings for a page
     */
    public static function getOrCreateForPage($professionalId, $pageType = 'home')
    {
        return static::firstOrCreate(
            ['professional_id' => $professionalId, 'page_type' => $pageType],
            ['title' => '', 'description' => '', 'keywords' => '']
        );
    }
}