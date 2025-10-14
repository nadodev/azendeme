<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    protected $fillable = [
        'professional_id',
        'cash_register_id',
        'type',
        'category_id',
        'amount',
        'description',
        'notes',
        'payment_method_id',
        'status',
        'appointment_id',
        'customer_id',
        'service_id',
        'transaction_date',
        'paid_at',
        'created_by',
        'receipt_number',
        'receipt_pdf_path',
        'receipt_issued_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
        'paid_at' => 'datetime',
        'receipt_issued_at' => 'datetime',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class);
    }

    public function category()
    {
        return $this->belongsTo(TransactionCategory::class, 'category_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }

    // Métodos auxiliares
    public function isIncome()
    {
        return $this->type === 'income';
    }

    public function isExpense()
    {
        return $this->type === 'expense';
    }

    /**
     * Gera o número do recibo
     */
    public function generateReceiptNumber()
    {
        if (!$this->receipt_number && $this->isIncome()) {
            $this->receipt_number = ReceiptSequence::getNextNumber($this->professional_id);
            $this->receipt_issued_at = now();
            $this->save();
        }
        
        return $this->receipt_number;
    }

    /**
     * Verifica se tem recibo emitido
     */
    public function hasReceipt()
    {
        return !empty($this->receipt_number);
    }
}
