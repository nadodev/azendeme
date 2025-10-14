<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashPeriod extends Model
{
    protected $fillable = [
        'professional_id',
        'period_type',
        'period_start',
        'period_end',
        'opening_balance',
        'total_income',
        'total_expense',
        'closing_balance',
        'total_transactions',
        'total_appointments',
        'status',
        'closed_at',
        'closed_by',
        'notes',
        'report_pdf_path',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'closed_at' => 'datetime',
        'opening_balance' => 'decimal:2',
        'total_income' => 'decimal:2',
        'total_expense' => 'decimal:2',
        'closing_balance' => 'decimal:2',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function transactions()
    {
        return $this->hasMany(FinancialTransaction::class, 'cash_register_id');
    }

    /**
     * Calcula o balanço do período
     */
    public function calculateBalance()
    {
        $this->closing_balance = $this->opening_balance + $this->total_income - $this->total_expense;
        $this->save();
        
        return $this->closing_balance;
    }

    /**
     * Fecha o período
     */
    public function close($userId = null)
    {
        $this->status = 'closed';
        $this->closed_at = now();
        $this->closed_by = $userId;
        $this->calculateBalance();
        
        return $this;
    }
}
