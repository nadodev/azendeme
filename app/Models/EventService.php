<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventService extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'equipment_id',
        'hours',
        'hourly_rate',
        'total_value',
        'notes',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'total_value' => 'decimal:2',
    ];

    /**
     * Get the event that owns the service.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the equipment for the service.
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(EventEquipment::class, 'equipment_id');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($service) {
            $service->total_value = $service->hours * $service->hourly_rate;
        });
    }
}