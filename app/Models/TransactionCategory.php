<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionCategory extends Model
{
    protected $fillable = [
        'professional_id',
        'name',
        'type',
        'color',
        'icon',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function transactions()
    {
        return $this->hasMany(FinancialTransaction::class, 'category_id');
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }
}
