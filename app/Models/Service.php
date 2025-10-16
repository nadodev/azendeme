<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'professional_id',
        'assigned_employer_id',
        'name',
        'description',
        'duration',
        'price',
        'allows_multiple',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function assignedEmployer(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_employer_id');
    }

    public function appointmentServices(): HasMany
    {
        return $this->hasMany(AppointmentService::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_service');
    }
}
