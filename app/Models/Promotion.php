<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';
    
    protected $fillable = [
        'professional_id',
        'name',
        'description',
        'type',
        'discount_percentage',
        'discount_fixed',
        'bonus_points',
        'service_ids',
        'target_customer_ids',
        'target_segment',
        'active',
        'valid_from',
        'valid_until',
        'max_uses',
        'current_uses',
        'promo_code',
        'min_purchase',
        'max_uses_per_customer',
        'auto_send',
        'sent_at',
    ];

    protected $casts = [
        'service_ids' => 'array',
        'target_customer_ids' => 'array',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'active' => 'boolean',
        'auto_send' => 'boolean',
        'sent_at' => 'datetime',
        'discount_percentage' => 'decimal:2',
        'discount_fixed' => 'decimal:2',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
