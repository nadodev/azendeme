<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'cost_category_id',
        'cost_number',
        'cost_date',
        'description',
        'details',
        'amount',
        'cost_type',
        'payment_status',
        'due_date',
        'supplier',
        'invoice_number',
        'payment_reference',
        'status',
        'notes',
    ];

    protected $casts = [
        'cost_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function costCategory(): BelongsTo
    {
        return $this->belongsTo(EventCostCategory::class, 'cost_category_id');
    }

    /**
     * Get the cost type label.
     */
    public function getCostTypeLabelAttribute()
    {
        $types = [
            'fixo' => 'Fixo',
            'variavel' => 'Variável',
            'imprevisto' => 'Imprevisto',
        ];

        return $types[$this->cost_type] ?? $this->cost_type;
    }

    /**
     * Get the payment status label.
     */
    public function getPaymentStatusLabelAttribute()
    {
        $statuses = [
            'pendente' => 'Pendente',
            'pago' => 'Pago',
            'parcelado' => 'Parcelado',
        ];

        return $statuses[$this->payment_status] ?? $this->payment_status;
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'rascunho' => 'Rascunho',
            'confirmado' => 'Confirmado',
            'pago' => 'Pago',
            'cancelado' => 'Cancelado',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get the cost type color class.
     */
    public function getCostTypeColorAttribute()
    {
        $colors = [
            'fixo' => 'bg-blue-100 text-blue-800',
            'variavel' => 'bg-green-100 text-green-800',
            'imprevisto' => 'bg-red-100 text-red-800',
        ];

        return $colors[$this->cost_type] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get the payment status color class.
     */
    public function getPaymentStatusColorAttribute()
    {
        $colors = [
            'pendente' => 'bg-yellow-100 text-yellow-800',
            'pago' => 'bg-green-100 text-green-800',
            'parcelado' => 'bg-blue-100 text-blue-800',
        ];

        return $colors[$this->payment_status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get the status color class.
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'rascunho' => 'bg-gray-100 text-gray-800',
            'confirmado' => 'bg-blue-100 text-blue-800',
            'pago' => 'bg-green-100 text-green-800',
            'cancelado' => 'bg-red-100 text-red-800',
        ];

        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Check if cost is overdue.
     */
    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date < now()->toDateString() && $this->payment_status !== 'pago';
    }
}