<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\AlertSetting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AlertController extends Controller
{
    private int $professionalId = 1; // Hardcoded por enquanto

    /**
     * Listar alertas
     */
    public function index(Request $request): View
    {
        $query = Alert::forProfessional($this->professionalId)
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $alerts = $query->paginate(20);

        // Estatísticas
        $stats = [
            'total_alerts' => Alert::forProfessional($this->professionalId)->count(),
            'unread_alerts' => Alert::forProfessional($this->professionalId)->unread()->count(),
            'high_priority_alerts' => Alert::forProfessional($this->professionalId)->byPriority('high')->unread()->count(),
            'urgent_alerts' => Alert::forProfessional($this->professionalId)->byPriority('urgent')->unread()->count(),
        ];

        // Tipos de alerta disponíveis
        $alertTypes = [
            'new_appointment' => 'Novo Agendamento',
            'cancelled_appointment' => 'Agendamento Cancelado',
            'new_customer' => 'Novo Cliente',
            'payment_received' => 'Pagamento Recebido',
            'appointment_reminder' => 'Lembrete de Agendamento',
            'no_show' => 'Cliente Não Compareceu',
            'feedback_received' => 'Feedback Recebido',
            'service_completed' => 'Serviço Concluído',
        ];

        return view('panel.alerts.index', compact('alerts', 'stats', 'alertTypes'));
    }

    /**
     * Obter alertas via API (para notificações em tempo real)
     */
    public function getAlerts(): JsonResponse
    {
        $alerts = Alert::forProfessional($this->professionalId)
            ->unread()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'alerts' => $alerts,
            'unread_count' => Alert::forProfessional($this->professionalId)->unread()->count(),
        ]);
    }

    /**
     * Marcar alerta como lido
     */
    public function markAsRead(Alert $alert): JsonResponse
    {
        if ($alert->professional_id !== $this->professionalId) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $alert->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Marcar todos os alertas como lidos
     */
    public function markAllAsRead(): JsonResponse
    {
        Alert::forProfessional($this->professionalId)
            ->unread()
            ->update([
                'status' => 'read',
                'read_at' => now(),
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * Arquivar alerta
     */
    public function archive(Alert $alert): JsonResponse
    {
        if ($alert->professional_id !== $this->professionalId) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $alert->markAsArchived();

        return response()->json(['success' => true]);
    }

    /**
     * Configurações de alertas
     */
    public function settings(): View
    {
        $settings = AlertSetting::forProfessional($this->professionalId)->get();

        $alertTypes = [
            'new_appointment' => 'Novo Agendamento',
            'cancelled_appointment' => 'Agendamento Cancelado',
            'new_customer' => 'Novo Cliente',
            'payment_received' => 'Pagamento Recebido',
            'appointment_reminder' => 'Lembrete de Agendamento',
            'no_show' => 'Cliente Não Compareceu',
            'feedback_received' => 'Feedback Recebido',
            'service_completed' => 'Serviço Concluído',
        ];

        return view('panel.alerts.settings', compact('settings', 'alertTypes'));
    }

    /**
     * Atualizar configurações de alertas
     */
    public function updateSettings(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.alert_type' => 'required|string',
            'settings.*.enabled' => 'boolean',
            'settings.*.channels' => 'nullable|array',
            'settings.*.conditions' => 'nullable|array',
        ]);

        foreach ($validated['settings'] as $settingData) {
            AlertSetting::updateOrCreate(
                [
                    'professional_id' => $this->professionalId,
                    'alert_type' => $settingData['alert_type'],
                ],
                [
                    'enabled' => $settingData['enabled'] ?? true,
                    'channels' => $settingData['channels'] ?? null,
                    'conditions' => $settingData['conditions'] ?? null,
                ]
            );
        }

        return response()->json(['success' => true]);
    }

    /**
     * Obter estatísticas de alertas
     */
    public function getStats(): JsonResponse
    {
        $stats = [
            'total_alerts' => Alert::forProfessional($this->professionalId)->count(),
            'unread_alerts' => Alert::forProfessional($this->professionalId)->unread()->count(),
            'alerts_today' => Alert::forProfessional($this->professionalId)
                ->whereDate('created_at', today())->count(),
            'alerts_this_week' => Alert::forProfessional($this->professionalId)
                ->where('created_at', '>=', now()->startOfWeek())->count(),
            'alerts_by_type' => Alert::forProfessional($this->professionalId)
                ->selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type'),
            'alerts_by_priority' => Alert::forProfessional($this->professionalId)
                ->selectRaw('priority, COUNT(*) as count')
                ->groupBy('priority')
                ->pluck('count', 'priority'),
        ];

        return response()->json($stats);
    }
}