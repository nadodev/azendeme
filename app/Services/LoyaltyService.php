<?php

namespace App\Services;

use App\Models\{LoyaltyProgram, LoyaltyPoint, LoyaltyReward, Appointment, Customer};
use Carbon\Carbon;

class LoyaltyService
{
    /**
     * Processa pontos após um agendamento concluído
     */
    public function processAppointmentPoints(Appointment $appointment)
    {
        $program = LoyaltyProgram::where('professional_id', $appointment->professional_id)
            ->where('active', true)
            ->first();

        if (!$program) {
            return null;
        }

        $loyaltyPoint = LoyaltyPoint::firstOrCreate(
            [
                'professional_id' => $appointment->professional_id,
                'customer_id' => $appointment->customer_id,
            ],
            [
                'points' => 0,
                'total_earned' => 0,
                'total_redeemed' => 0,
            ]
        );

        // Calcula pontos: por visita + por valor gasto
        $pointsFromVisit = $program->points_per_visit;
        $pointsFromSpending = ($appointment->total_price ?? $appointment->service->price) * $program->points_per_currency;
        $totalPoints = $pointsFromVisit + $pointsFromSpending;

        // Define expiração se configurado
        $expiresAt = $program->points_expiry_days 
            ? Carbon::now()->addDays($program->points_expiry_days)
            : null;

        $loyaltyPoint->addPoints(
            $totalPoints,
            "Agendamento #{$appointment->id}",
            $appointment->id,
            $expiresAt
        );

        return $totalPoints;
    }

    /**
     * Verifica recompensas disponíveis para um cliente
     */
    public function getAvailableRewards($professionalId, $customerId)
    {
        $loyaltyPoint = LoyaltyPoint::where('professional_id', $professionalId)
            ->where('customer_id', $customerId)
            ->first();

        if (!$loyaltyPoint) {
            return collect();
        }

        return LoyaltyReward::where('professional_id', $professionalId)
            ->where('active', true)
            ->where('points_required', '<=', $loyaltyPoint->points)
            ->where(function($q) {
                $q->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->where(function($q) {
                $q->whereNull('max_redemptions')
                    ->orWhereRaw('current_redemptions < max_redemptions');
            })
            ->get();
    }

    /**
     * Expira pontos antigos
     */
    public function expireOldPoints($professionalId)
    {
        $expiredTransactions = \App\Models\LoyaltyTransaction::where('professional_id', $professionalId)
            ->where('type', 'earned')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->whereNotIn('id', function($query) {
                $query->select('id')
                    ->from('loyalty_transactions')
                    ->where('type', 'expired');
            })
            ->get();

        foreach ($expiredTransactions as $transaction) {
            $loyaltyPoint = LoyaltyPoint::where('professional_id', $professionalId)
                ->where('customer_id', $transaction->customer_id)
                ->first();

            if ($loyaltyPoint && $loyaltyPoint->points >= $transaction->points) {
                $loyaltyPoint->points -= $transaction->points;
                $loyaltyPoint->save();

                \App\Models\LoyaltyTransaction::create([
                    'professional_id' => $professionalId,
                    'customer_id' => $transaction->customer_id,
                    'type' => 'expired',
                    'points' => -$transaction->points,
                    'description' => "Pontos expirados da transação #{$transaction->id}",
                ]);
            }
        }

        return $expiredTransactions->count();
    }
}

