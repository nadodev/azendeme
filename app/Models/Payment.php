<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'payment_method_id',
        'amount',
        'status',
        'transaction_id',
        'gateway_response',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'paid_at' => 'datetime',
    ];

    /**
     * Relacionamento com Appointment
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Relacionamento com PaymentMethod
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Scope para pagamentos concluídos
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope para pagamentos pendentes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope para pagamentos falhados
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope para pagamentos reembolsados
     */
    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    /**
     * Marcar como pago
     */
    public function markAsPaid(): void
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }

    /**
     * Marcar como falhado
     */
    public function markAsFailed(): void
    {
        $this->update([
            'status' => 'failed',
        ]);
    }

    /**
     * Marcar como reembolsado
     */
    public function markAsRefunded(): void
    {
        $this->update([
            'status' => 'refunded',
        ]);
    }

    /**
     * Obter nome do status em português
     */
    public function getStatusNameAttribute(): string
    {
        $statuses = [
            'pending' => 'Pendente',
            'completed' => 'Concluído',
            'failed' => 'Falhado',
            'refunded' => 'Reembolsado',
        ];

        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Obter cor do status
     */
    public function getStatusColorAttribute(): string
    {
        $colors = [
            'pending' => 'text-yellow-600 bg-yellow-100',
            'completed' => 'text-green-600 bg-green-100',
            'failed' => 'text-red-600 bg-red-100',
            'refunded' => 'text-gray-600 bg-gray-100',
        ];

        return $colors[$this->status] ?? 'text-gray-600 bg-gray-100';
    }
}