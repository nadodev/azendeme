<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professional extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'logo',
        'photo',
        'specialty',
        'commission_percentage',
        'is_main',
        'brand_color',
        'template',
        'business_name',
        'bio',
        'subdomain',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function eventEquipment(): HasMany
    {
        return $this->hasMany(EventEquipment::class);
    }

    public function eventCostCategories(): HasMany
    {
        return $this->hasMany(EventCostCategory::class);
    }

    public function blockedDates(): HasMany
    {
        return $this->hasMany(BlockedDate::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function templateSetting()
    {
        return $this->hasOne(TemplateSetting::class);
    }

    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function transactionCategories(): HasMany
    {
        return $this->hasMany(TransactionCategory::class);
    }

    public function cashRegisters(): HasMany
    {
        return $this->hasMany(CashRegister::class);
    }

    public function financialTransactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    public function assignedServices(): HasMany
    {
        return $this->hasMany(Service::class, 'assigned_professional_id');
    }
}
