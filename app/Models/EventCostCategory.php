<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventCostCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'name',
        'description',
        'color',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function costs(): HasMany
    {
        return $this->hasMany(EventCost::class, 'cost_category_id');
    }

    /**
     * Get the total amount for this category in an event.
     */
    public function getTotalForEvent($eventId)
    {
        return $this->costs()->where('event_id', $eventId)->sum('amount');
    }

    /**
     * Get the total amount for this category across all events.
     */
    public function getTotalAmount()
    {
        return $this->costs()->sum('amount');
    }
}