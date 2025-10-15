<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'payment_id',
        'receipt_number',
        'receipt_date',
        'description',
        'amount',
        'payment_method',
        'payment_reference',
        'payer_name',
        'payer_document',
        'payer_address',
        'services_description',
        'status',
        'notes',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(EventPayment::class, 'payment_id');
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
            'rascunho' => 'Rascunho',
            'emitido' => 'Emitido',
            'pago' => 'Pago',
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
            'emitido' => 'bg-blue-100 text-blue-800',
            'pago' => 'bg-green-100 text-green-800',
            'cancelado' => 'bg-red-100 text-red-800',
        ];

        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}