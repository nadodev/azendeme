<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'budget_id',
        'contract_number',
        'contract_date',
        'start_date',
        'end_date',
        'terms_and_conditions',
        'payment_terms',
        'cancellation_policy',
        'liability_terms',
        'total_value',
        'advance_payment',
        'final_payment',
        'status',
        'signed_date',
        'signature_data',
        'notes',
    ];

    protected $casts = [
        'contract_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'signed_date' => 'date',
        'total_value' => 'decimal:2',
        'advance_payment' => 'decimal:2',
        'final_payment' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(EventBudget::class);
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'rascunho' => 'Rascunho',
            'enviado' => 'Enviado',
            'assinado' => 'Assinado',
            'ativo' => 'Ativo',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado',
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
            'enviado' => 'bg-blue-100 text-blue-800',
            'assinado' => 'bg-green-100 text-green-800',
            'ativo' => 'bg-purple-100 text-purple-800',
            'concluido' => 'bg-indigo-100 text-indigo-800',
            'cancelado' => 'bg-red-100 text-red-800',
        ];

        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Check if contract is signed.
     */
    public function getIsSignedAttribute()
    {
        return $this->status === 'assinado' || $this->status === 'ativo' || $this->status === 'concluido';
    }

    /**
     * Check if contract is active.
     */
    public function getIsActiveAttribute()
    {
        return $this->status === 'ativo';
    }
}