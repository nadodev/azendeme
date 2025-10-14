<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    protected $fillable = [
        'professional_id',
        'customer_id',
        'points',
        'total_earned',
        'total_redeemed',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function transactions()
    {
        return $this->hasMany(LoyaltyTransaction::class, 'customer_id', 'customer_id');
    }

    /**
     * Adiciona pontos
     */
    public function addPoints($points, $description = null, $appointmentId = null, $expiresAt = null)
    {
        $this->points += $points;
        $this->total_earned += $points;
        $this->save();

        LoyaltyTransaction::create([
            'professional_id' => $this->professional_id,
            'customer_id' => $this->customer_id,
            'appointment_id' => $appointmentId,
            'type' => 'earned',
            'points' => $points,
            'description' => $description,
            'expires_at' => $expiresAt,
        ]);

        return $this;
    }

    /**
     * Resgata pontos
     */
    public function redeemPoints($points, $description = null)
    {
        if ($this->points < $points) {
            throw new \Exception('Pontos insuficientes');
        }

        $this->points -= $points;
        $this->total_redeemed += $points;
        $this->save();

        LoyaltyTransaction::create([
            'professional_id' => $this->professional_id,
            'customer_id' => $this->customer_id,
            'type' => 'redeemed',
            'points' => -$points,
            'description' => $description,
        ]);

        return $this;
    }
}
