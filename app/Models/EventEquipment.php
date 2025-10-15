<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventEquipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'name',
        'description',
        'hourly_rate',
        'minimum_hours',
        'is_active',
        'setup_requirements',
        'technical_specs',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the professional that owns the equipment.
     */
    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Get the services that use this equipment.
     */
    public function services(): HasMany
    {
        return $this->hasMany(EventService::class, 'equipment_id');
    }

    /**
     * Scope a query to only include active equipment.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}