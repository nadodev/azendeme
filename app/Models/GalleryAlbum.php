<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryAlbum extends Model
{
    protected $fillable = [
        'professional_id',
        'name',
        'description',
        'cover_image',
        'order',
    ];

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Gallery::class, 'album_id');
    }
}


