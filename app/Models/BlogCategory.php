<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'name',
        'slug',
        'description',
        'color',
        'active',
        'sort_order',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }

    public function publishedPosts()
    {
        return $this->hasMany(BlogPost::class, 'category_id')
                    ->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}