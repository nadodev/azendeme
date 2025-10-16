<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Helpers\ActivityLogger;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        ActivityLogger::log(
            action: 'created',
            entityType: 'appointment',
            entityId: $appointment->id,
            professionalId: $appointment->professional_id,
            appointmentId: $appointment->id,
            customerId: $appointment->customer_id,
            userId: auth()->id(),
            description: "Agendamento criado para {$appointment->customer->name} - {$appointment->service->name}",
            request: request()
        );
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment): void
    {
        // Verificar se o status mudou
        if ($appointment->wasChanged('status')) {
            $oldStatus = $appointment->getOriginal('status');
            $newStatus = $appointment->status;
            
            $statusNames = [
                'pending' => 'Pendente',
                'confirmed' => 'Confirmado',
                'cancelled' => 'Cancelado',
                'completed' => 'Concluído',
                'no_show' => 'Não Compareceu'
            ];

            ActivityLogger::log(
                action: $newStatus, // confirmed, cancelled, completed, no_show
                entityType: 'appointment',
                entityId: $appointment->id,
                professionalId: $appointment->professional_id,
                appointmentId: $appointment->id,
                customerId: $appointment->customer_id,
                userId: auth()->id(),
                oldValues: ['status' => $statusNames[$oldStatus] ?? $oldStatus],
                newValues: ['status' => $statusNames[$newStatus] ?? $newStatus],
                description: "Status alterado de {$statusNames[$oldStatus]} para {$statusNames[$newStatus]}",
                request: request()
            );
        } else {
            // Outras atualizações
            ActivityLogger::log(
                action: 'updated',
                entityType: 'appointment',
                entityId: $appointment->id,
                professionalId: $appointment->professional_id,
                appointmentId: $appointment->id,
                customerId: $appointment->customer_id,
                userId: auth()->id(),
                oldValues: $appointment->getOriginal(),
                newValues: $appointment->getAttributes(),
                description: "Agendamento atualizado para {$appointment->customer->name}",
                request: request()
            );
        }
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        ActivityLogger::log(
            action: 'deleted',
            entityType: 'appointment',
            entityId: $appointment->id,
            professionalId: $appointment->professional_id,
            appointmentId: $appointment->id,
            customerId: $appointment->customer_id,
            userId: auth()->id(),
            description: "Agendamento excluído - {$appointment->customer->name} - {$appointment->service->name}",
            request: request()
        );
    }
}
