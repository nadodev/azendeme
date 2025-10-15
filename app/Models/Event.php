<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'customer_id',
        'title',
        'description',
        'type',
        'event_date',
        'start_time',
        'end_time',
        'address',
        'city',
        'state',
        'zip_code',
        'status',
        'total_value',
        'discount',
        'final_value',
        'notes',
        'equipment_notes',
        'setup_notes',
    ];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_value' => 'decimal:2',
        'discount' => 'decimal:2',
        'final_value' => 'decimal:2',
    ];

    /**
     * Get the professional that owns the event.
     */
    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Get the customer that owns the event.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the services for the event.
     */
    public function services(): HasMany
    {
        return $this->hasMany(EventService::class);
    }

    /**
     * Get the employees for the event.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(EventEmployee::class);
    }

    /**
     * Get the budgets for the event.
     */
    public function budgets(): HasMany
    {
        return $this->hasMany(EventBudget::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(EventInvoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(EventPayment::class);
    }

    public function serviceOrders(): HasMany
    {
        return $this->hasMany(EventServiceOrder::class);
    }

    /**
     * Get the contracts for the event.
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(EventContract::class);
    }

    /**
     * Get the service notes for the event.
     */
    public function serviceNotes(): HasMany
    {
        return $this->hasMany(EventServiceNote::class);
    }

    /**
     * Get the commercial proposals for the event.
     */
    public function commercialProposals(): HasMany
    {
        return $this->hasMany(EventCommercialProposal::class);
    }

    /**
     * Get the receipts for the event.
     */
    public function receipts(): HasMany
    {
        return $this->hasMany(EventReceipt::class);
    }

    /**
     * Get the costs for the event.
     */
    public function costs(): HasMany
    {
        return $this->hasMany(EventCost::class);
    }

    /**
     * Get the latest budget for the event.
     */
    public function latestBudget()
    {
        return $this->budgets()->latest()->first();
    }

    /**
     * Get the total value of equipment services.
     */
    public function getTotalEquipmentValueAttribute()
    {
        return $this->services()->sum('total_value');
    }

    /**
     * Get the total value of employee services.
     */
    public function getTotalEmployeeValueAttribute()
    {
        return $this->employees()->sum('total_value');
    }

    /**
     * Get the duration of the event in hours.
     */
    public function getDurationAttribute()
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        
        // Se o horário de término for menor que o de início, assumimos que é no dia seguinte
        if ($end->lessThan($start)) {
            $end->addDay();
        }
        
        return $start->diffInHours($end);
    }

    /**
     * Get the total amount invoiced for this event.
     */
    public function getTotalInvoicedAttribute()
    {
        return $this->invoices()->sum('total');
    }

    /**
     * Get the total amount paid for this event.
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
        return $this->total_invoiced - $this->total_paid;
    }

    /**
     * Check if the event is fully paid.
     */
    public function getIsFullyPaidAttribute()
    {
        return $this->remaining_amount <= 0;
    }

    /**
     * Get the latest invoice for the event.
     */
    public function latestInvoice()
    {
        return $this->invoices()->latest()->first();
    }

    /**
     * Get the latest service order for the event.
     */
    public function latestServiceOrder()
    {
        return $this->serviceOrders()->latest()->first();
    }
}