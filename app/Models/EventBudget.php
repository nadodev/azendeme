<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'budget_number',
        'valid_until',
        'equipment_total',
        'employees_total',
        'subtotal',
        'discount_percentage',
        'discount_value',
        'total',
        'status',
        'notes',
        'terms',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'equipment_total' => 'decimal:2',
        'employees_total' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Get the event that owns the budget.
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

        static::creating(function ($budget) {
            if (empty($budget->budget_number)) {
                $budget->budget_number = 'ORC-' . str_pad(EventBudget::count() + 1, 6, '0', STR_PAD_LEFT);
            }
        });

        static::saving(function ($budget) {
            // Calculate totals
            $budget->equipment_total = $budget->event->total_equipment_value;
            $budget->employees_total = $budget->event->total_employee_value;
            $budget->subtotal = $budget->equipment_total + $budget->employees_total;
            
            // Calculate discount
            if ($budget->discount_percentage > 0) {
                $budget->discount_value = ($budget->subtotal * $budget->discount_percentage) / 100;
            }
            
            $budget->total = $budget->subtotal - $budget->discount_value;
        });
    }
}