<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventServiceOrder extends Model
{
    use HasFactory;

    protected $table = 'event_service_orders';

    protected $fillable = [
        'event_id',
        'budget_id',
        'order_number',
        'order_date',
        'scheduled_date',
        'scheduled_start_time',
        'scheduled_end_time',
        'description',
        'equipment_list',
        'employee_assignments',
        'setup_instructions',
        'special_requirements',
        'status',
        'completion_notes',
        'issues_encountered',
        'total_value',
    ];

    protected $casts = [
        'order_date' => 'date',
        'scheduled_date' => 'date',
        'scheduled_start_time' => 'datetime',
        'scheduled_end_time' => 'datetime',
        'total_value' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(EventBudget::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(EventInvoice::class, 'service_order_id');
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'rascunho' => 'Rascunho',
            'agendada' => 'Agendada',
            'em_execucao' => 'Em Execução',
            'concluida' => 'Concluída',
            'cancelada' => 'Cancelada',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get the status color class.
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'rascunho' => 'bg-gray-100 text-gray-800',
            'agendada' => 'bg-blue-100 text-blue-800',
            'em_execucao' => 'bg-yellow-100 text-yellow-800',
            'concluida' => 'bg-green-100 text-green-800',
            'cancelada' => 'bg-red-100 text-red-800',
        ];

        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Check if the service order is completed.
     */
    public function getIsCompletedAttribute()
    {
        return $this->status === 'concluida';
    }

    /**
     * Check if the service order is in progress.
     */
    public function getIsInProgressAttribute()
    {
        return $this->status === 'em_execucao';
    }

    /**
     * Check if the service order is scheduled.
     */
    public function getIsScheduledAttribute()
    {
        return $this->status === 'agendada';
    }

    /**
     * Get the latest invoice for the service order.
     */
    public function latestInvoice()
    {
        return $this->invoices()->latest()->first();
    }
}