<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CashRegister extends Model
{
    protected $fillable = [
        'professional_id',
        'date',
        'opening_balance',
        'total_income',
        'total_expense',
        'closing_balance',
        'status',
        'opened_at',
        'closed_at',
        'opened_by',
        'closed_by',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'opening_balance' => 'decimal:2',
        'total_income' => 'decimal:2',
        'total_expense' => 'decimal:2',
        'closing_balance' => 'decimal:2',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function transactions()
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function openedBy()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', Carbon::today());
    }

    public function getNetBalanceAttribute()
    {
        return $this->opening_balance + $this->total_income - $this->total_expense;
    }
}
