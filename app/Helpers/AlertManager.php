<?php

namespace App\Helpers;

use App\Models\Alert;
use App\Models\AlertSetting;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Payment;

class AlertManager
{
    /**
     * Criar um alerta
     */
    public static function create(
        int $professionalId,
        string $type,
        string $title,
        string $message,
        array $data = [],
        string $priority = 'medium'
    ): Alert {
        // Verificar se o alerta está habilitado
        $setting = AlertSetting::forProfessional($professionalId)
            ->where('alert_type', $type)
            ->first();

        if (!$setting || !$setting->enabled) {
            return null;
        }

        return Alert::create([
            'professional_id' => $professionalId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'priority' => $priority,
        ]);
    }

    /**
     * Alertar sobre novo agendamento
     */
    public static function newAppointment(Appointment $appointment): ?Alert
    {
        $customer = $appointment->customer;
        $service = $appointment->service;
        $startTime = \Carbon\Carbon::parse($appointment->start_time);

        return self::create(
            professionalId: $appointment->professional_id,
            type: 'new_appointment',
            title: 'Novo Agendamento',
            message: "Novo agendamento de {$customer->name} para {$service->name} em {$startTime->format('d/m/Y H:i')}",
            data: [
                'appointment_id' => $appointment->id,
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'appointment_date' => $appointment->start_time,
            ],
            priority: 'medium'
        );
    }

    /**
     * Alertar sobre cancelamento de agendamento
     */
    public static function cancelledAppointment(Appointment $appointment, ?string $reason = null): ?Alert
    {
        $customer = $appointment->customer;
        $service = $appointment->service;
        $startTime = \Carbon\Carbon::parse($appointment->start_time);

        $message = "Agendamento cancelado: {$customer->name} - {$service->name} em {$startTime->format('d/m/Y H:i')}";
        if ($reason) {
            $message .= " (Motivo: {$reason})";
        }

        return self::create(
            professionalId: $appointment->professional_id,
            type: 'cancelled_appointment',
            title: 'Agendamento Cancelado',
            message: $message,
            data: [
                'appointment_id' => $appointment->id,
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'appointment_date' => $appointment->start_time,
                'cancellation_reason' => $reason,
            ],
            priority: 'high'
        );
    }

    /**
     * Alertar sobre novo cliente
     */
    public static function newCustomer(Customer $customer): ?Alert
    {
        return self::create(
            professionalId: $customer->professional_id,
            type: 'new_customer',
            title: 'Novo Cliente Cadastrado',
            message: "Novo cliente cadastrado: {$customer->name} ({$customer->phone})",
            data: [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'customer_email' => $customer->email,
            ],
            priority: 'low'
        );
    }

    /**
     * Alertar sobre pagamento recebido
     */
    public static function paymentReceived(Payment $payment): ?Alert
    {
        $appointment = $payment->appointment;
        $customer = $appointment->customer;
        $amount = number_format($payment->amount, 2, ',', '.');

        return self::create(
            professionalId: $appointment->professional_id,
            type: 'payment_received',
            title: 'Pagamento Recebido',
            message: "Pagamento de R$ {$amount} recebido de {$customer->name} via {$payment->paymentMethod->name}",
            data: [
                'payment_id' => $payment->id,
                'appointment_id' => $appointment->id,
                'customer_id' => $customer->id,
                'amount' => $payment->amount,
                'payment_method' => $payment->paymentMethod->name,
            ],
            priority: 'medium'
        );
    }

    /**
     * Alertar sobre lembrete de agendamento
     */
    public static function appointmentReminder(Appointment $appointment): ?Alert
    {
        $customer = $appointment->customer;
        $service = $appointment->service;
        $startTime = \Carbon\Carbon::parse($appointment->start_time);

        return self::create(
            professionalId: $appointment->professional_id,
            type: 'appointment_reminder',
            title: 'Lembrete de Agendamento',
            message: "Lembrete: {$customer->name} tem agendamento para {$service->name} em {$startTime->format('d/m/Y H:i')}",
            data: [
                'appointment_id' => $appointment->id,
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'appointment_date' => $appointment->start_time,
            ],
            priority: 'medium'
        );
    }

    /**
     * Alertar sobre não comparecimento
     */
    public static function noShow(Appointment $appointment): ?Alert
    {
        $customer = $appointment->customer;
        $service = $appointment->service;
        $startTime = \Carbon\Carbon::parse($appointment->start_time);

        return self::create(
            professionalId: $appointment->professional_id,
            type: 'no_show',
            title: 'Cliente Não Compareceu',
            message: "Cliente {$customer->name} não compareceu ao agendamento de {$service->name} em {$startTime->format('d/m/Y H:i')}",
            data: [
                'appointment_id' => $appointment->id,
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'appointment_date' => $appointment->start_time,
            ],
            priority: 'high'
        );
    }

    /**
     * Alertar sobre feedback recebido
     */
    public static function feedbackReceived(Appointment $appointment, array $feedbackData): ?Alert
    {
        $customer = $appointment->customer;
        $service = $appointment->service;

        return self::create(
            professionalId: $appointment->professional_id,
            type: 'feedback_received',
            title: 'Feedback Recebido',
            message: "Feedback recebido de {$customer->name} para o serviço {$service->name}",
            data: [
                'appointment_id' => $appointment->id,
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'feedback_data' => $feedbackData,
            ],
            priority: 'low'
        );
    }

    /**
     * Alertar sobre serviço concluído
     */
    public static function serviceCompleted(Appointment $appointment): ?Alert
    {
        $customer = $appointment->customer;
        $service = $appointment->service;

        return self::create(
            professionalId: $appointment->professional_id,
            type: 'service_completed',
            title: 'Serviço Concluído',
            message: "Serviço {$service->name} concluído para {$customer->name}",
            data: [
                'appointment_id' => $appointment->id,
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'completed_at' => now(),
            ],
            priority: 'low'
        );
    }

    /**
     * Obter contagem de alertas não lidos
     */
    public static function getUnreadCount(int $professionalId): int
    {
        return Alert::forProfessional($professionalId)
            ->unread()
            ->count();
    }

    /**
     * Obter alertas recentes
     */
    public static function getRecentAlerts(int $professionalId, int $limit = 10)
    {
        return Alert::forProfessional($professionalId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Marcar todos os alertas como lidos
     */
    public static function markAllAsRead(int $professionalId): void
    {
        Alert::forProfessional($professionalId)
            ->unread()
            ->update([
                'status' => 'read',
                'read_at' => now(),
            ]);
    }
}
