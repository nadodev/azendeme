<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;

class Employee extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'professional_id', 'name', 'email', 'phone', 'cpf', 'color', 'active', 'show_in_booking'
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'employee_service');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }
}


