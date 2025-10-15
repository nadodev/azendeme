<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'budget_id',
        'service_order_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'subtotal',
        'discount_percentage',
        'discount_value',
        'tax_percentage',
        'tax_value',
        'total',
        'status',
        'notes',
        'payment_terms',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_value' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(EventBudget::class);
    }

    public function serviceOrder(): BelongsTo
    {
        return $this->belongsTo(EventServiceOrder::class, 'service_order_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(EventPayment::class, 'invoice_id');
    }

    /**
     * Get the total amount paid for this invoice.
     */
    public function getTotalPaidAttribute()
    {
        return $this->payments()->where('status', 'confirmado')->sum('amount');
    }

    /**
     * Get the remaining amount to be paid.
     */
    public function getRemainingAmountAttribute()
    {
        return $this->total - $this->total_paid;
    }

    /**
     * Check if the invoice is fully paid.
     */
    public function getIsFullyPaidAttribute()
    {
        return round($this->remaining_amount, 2) <= 0;
    }

    /**
     * Check if the invoice is overdue.
     */
    public function getIsOverdueAttribute()
    {
        return $this->due_date < now() && !$this->is_fully_paid;
    }
}