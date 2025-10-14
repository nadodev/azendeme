<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    protected $table = 'waitlist';
    
    protected $fillable = [
        'professional_id',
        'customer_id',
        'service_id',
        'preferred_date',
        'preferred_time_start',
        'preferred_time_end',
        'notes',
        'status',
        'notified_at',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'notified_at' => 'datetime',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeWaiting($query)
    {
        return $query->where('status', 'waiting');
    }

    public function scopeNotified($query)
    {
        return $query->where('status', 'notified');
    }
}
