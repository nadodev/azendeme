<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QuickBookingLink extends Model
{
    protected $fillable = [
        'professional_id',
        'service_id',
        'token',
        'name',
        'description',
        'active',
        'max_uses',
        'uses_count',
        'expires_at',
    ];

    protected $casts = [
        'active' => 'boolean',
        'expires_at' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($link) {
            if (!$link->token) {
                $link->token = Str::random(32);
            }
        });
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
            })
            ->where(function($q) {
                $q->whereNull('max_uses')
                  ->orWhereRaw('uses_count < max_uses');
            });
    }

    public function getUrlAttribute()
    {
        return url('/agendar/' . $this->token);
    }

    public function incrementUses()
    {
        $this->increment('uses_count');
        
        if ($this->max_uses && $this->uses_count >= $this->max_uses) {
            $this->update(['active' => false]);
        }
    }

    public function isValid()
    {
        if (!$this->active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at < now()) {
            return false;
        }

        if ($this->max_uses && $this->uses_count >= $this->max_uses) {
            return false;
        }

        return true;
    }
}
