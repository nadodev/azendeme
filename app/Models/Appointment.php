<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'professional_id',
        'service_id',
        'customer_id',
        'start_time',
        'end_time',
        'status',
        'notes',
        'is_recurring',
        'recurrence_type',
        'recurrence_interval',
        'parent_appointment_id',
        'total_price',
        'total_duration',
        'has_multiple_services',
        'confirmation_token',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function appointmentServices()
    {
        return $this->hasMany(AppointmentService::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'appointment_services')
            ->withPivot('price', 'duration', 'assigned_professional_id')
            ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Calcula o preço total baseado nos serviços
     */
    public function calculateTotalPrice()
    {
        if ($this->has_multiple_services) {
            $this->total_price = $this->appointmentServices()->sum('price');
        } else {
            $this->total_price = $this->service->price ?? 0;
        }
        $this->save();
        
        return $this->total_price;
    }

    /**
     * Calcula a duração total baseada nos serviços
     */
    public function calculateTotalDuration()
    {
        if ($this->has_multiple_services) {
            $this->total_duration = $this->appointmentServices()->sum('duration');
        } else {
            $this->total_duration = $this->service->duration ?? 0;
        }
        $this->save();
        
        return $this->total_duration;
    }
}
