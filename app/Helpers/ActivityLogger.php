<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogger
{
    /**
     * Registrar uma atividade
     */
    public static function log(
        string $action,
        string $entityType,
        ?int $entityId = null,
        ?int $professionalId = null,
        ?int $appointmentId = null,
        ?int $customerId = null,
        ?int $userId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null,
        ?Request $request = null
    ): ActivityLog {
        // Se não foi fornecido professionalId, tentar obter do contexto atual
        if (!$professionalId) {
            $professionalId = 1; // Por enquanto hardcoded, depois pode ser obtido da sessão
        }

        // Obter informações da requisição se disponível
        $ipAddress = null;
        $userAgent = null;
        
        if ($request) {
            $ipAddress = $request->ip();
            $userAgent = $request->userAgent();
        }

        return ActivityLog::create([
            'professional_id' => $professionalId,
            'appointment_id' => $appointmentId,
            'customer_id' => $customerId,
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    }

    /**
     * Log para criação de agendamento
     */
    public static function logAppointmentCreated(
        int $appointmentId,
        int $customerId,
        ?int $userId = null,
        ?Request $request = null
    ): ActivityLog {
        return self::log(
            action: 'created',
            entityType: 'appointment',
            entityId: $appointmentId,
            appointmentId: $appointmentId,
            customerId: $customerId,
            userId: $userId,
            description: 'Novo agendamento criado',
            request: $request
        );
    }

    /**
     * Log para atualização de agendamento
     */
    public static function logAppointmentUpdated(
        int $appointmentId,
        int $customerId,
        array $oldValues,
        array $newValues,
        ?int $userId = null,
        ?Request $request = null
    ): ActivityLog {
        return self::log(
            action: 'updated',
            entityType: 'appointment',
            entityId: $appointmentId,
            appointmentId: $appointmentId,
            customerId: $customerId,
            userId: $userId,
            oldValues: $oldValues,
            newValues: $newValues,
            description: 'Agendamento atualizado',
            request: $request
        );
    }

    /**
     * Log para cancelamento de agendamento
     */
    public static function logAppointmentCancelled(
        int $appointmentId,
        int $customerId,
        ?int $userId = null,
        ?string $reason = null,
        ?Request $request = null
    ): ActivityLog {
        $description = 'Agendamento cancelado';
        if ($reason) {
            $description .= ": {$reason}";
        }

        return self::log(
            action: 'cancelled',
            entityType: 'appointment',
            entityId: $appointmentId,
            appointmentId: $appointmentId,
            customerId: $customerId,
            userId: $userId,
            description: $description,
            request: $request
        );
    }

    /**
     * Log para confirmação de agendamento
     */
    public static function logAppointmentConfirmed(
        int $appointmentId,
        int $customerId,
        ?int $userId = null,
        ?Request $request = null
    ): ActivityLog {
        return self::log(
            action: 'confirmed',
            entityType: 'appointment',
            entityId: $appointmentId,
            appointmentId: $appointmentId,
            customerId: $customerId,
            userId: $userId,
            description: 'Agendamento confirmado',
            request: $request
        );
    }

    /**
     * Log para conclusão de agendamento
     */
    public static function logAppointmentCompleted(
        int $appointmentId,
        int $customerId,
        ?int $userId = null,
        ?Request $request = null
    ): ActivityLog {
        return self::log(
            action: 'completed',
            entityType: 'appointment',
            entityId: $appointmentId,
            appointmentId: $appointmentId,
            customerId: $customerId,
            userId: $userId,
            description: 'Agendamento concluído',
            request: $request
        );
    }

    /**
     * Log para reagendamento
     */
    public static function logAppointmentRescheduled(
        int $appointmentId,
        int $customerId,
        array $oldValues,
        array $newValues,
        ?int $userId = null,
        ?Request $request = null
    ): ActivityLog {
        return self::log(
            action: 'rescheduled',
            entityType: 'appointment',
            entityId: $appointmentId,
            appointmentId: $appointmentId,
            customerId: $customerId,
            userId: $userId,
            oldValues: $oldValues,
            newValues: $newValues,
            description: 'Agendamento reagendado',
            request: $request
        );
    }

    /**
     * Log para não comparecimento
     */
    public static function logAppointmentNoShow(
        int $appointmentId,
        int $customerId,
        ?int $userId = null,
        ?Request $request = null
    ): ActivityLog {
        return self::log(
            action: 'no_show',
            entityType: 'appointment',
            entityId: $appointmentId,
            appointmentId: $appointmentId,
            customerId: $customerId,
            userId: $userId,
            description: 'Cliente não compareceu ao agendamento',
            request: $request
        );
    }

    /**
     * Log para pagamento recebido
     */
    public static function logPaymentReceived(
        int $appointmentId,
        int $customerId,
        float $amount,
        string $paymentMethod,
        ?int $userId = null,
        ?Request $request = null
    ): ActivityLog {
        return self::log(
            action: 'payment_received',
            entityType: 'payment',
            entityId: $appointmentId,
            appointmentId: $appointmentId,
            customerId: $customerId,
            userId: $userId,
            newValues: [
                'amount' => $amount,
                'payment_method' => $paymentMethod,
            ],
            description: "Pagamento de R$ " . number_format($amount, 2, ',', '.') . " recebido via {$paymentMethod}",
            request: $request
        );
    }

    /**
     * Log para feedback enviado
     */
    public static function logFeedbackSent(
        int $appointmentId,
        int $customerId,
        ?int $userId = null,
        ?Request $request = null
    ): ActivityLog {
        return self::log(
            action: 'feedback_sent',
            entityType: 'appointment',
            entityId: $appointmentId,
            appointmentId: $appointmentId,
            customerId: $customerId,
            userId: $userId,
            description: 'Link de feedback enviado para o cliente',
            request: $request
        );
    }
}
