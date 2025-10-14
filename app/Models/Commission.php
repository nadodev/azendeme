<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'professional_id',
        'appointment_id',
        'financial_transaction_id',
        'service_amount',
        'commission_percentage',
        'commission_amount',
        'status',
        'period_start',
        'period_end',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'service_amount' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'period_start' => 'date',
        'period_end' => 'date',
        'paid_at' => 'datetime',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function financialTransaction()
    {
        return $this->belongsTo(FinancialTransaction::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeByPeriod($query, $start, $end)
    {
        return $query->whereBetween('period_start', [$start, $end]);
    }

    public static function calculateCommission($serviceAmount, $percentage)
    {
        return ($serviceAmount * $percentage) / 100;
    }
}
