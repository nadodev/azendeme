<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'phone',
        'email',
        'role',
        'hourly_rate',
        'hours',
        'total_value',
        'notes',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'total_value' => 'decimal:2',
    ];

    /**
     * Get the event that owns the employee.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($employee) {
            $employee->total_value = $employee->hours * $employee->hourly_rate;
        });
    }
}