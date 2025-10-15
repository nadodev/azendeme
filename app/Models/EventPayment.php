<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'invoice_id',
        'payment_number',
        'payment_date',
        'amount',
        'payment_method',
        'payment_reference',
        'status',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(EventInvoice::class);
    }

    /**
     * Get the payment method label.
     */
    public function getPaymentMethodLabelAttribute()
    {
        $methods = [
            'dinheiro' => 'Dinheiro',
            'cartao_credito' => 'Cartão de Crédito',
            'cartao_debito' => 'Cartão de Débito',
            'pix' => 'PIX',
            'transferencia' => 'Transferência',
            'cheque' => 'Cheque',
            'outro' => 'Outro',
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pendente' => 'Pendente',
            'confirmado' => 'Confirmado',
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
            'pendente' => 'bg-yellow-100 text-yellow-800',
            'confirmado' => 'bg-green-100 text-green-800',
            'cancelado' => 'bg-red-100 text-red-800',
        ];

        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}