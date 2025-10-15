<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    protected $professionalId;
    public function __construct()
    {
        $this->professionalId = auth()->user()->id;
    }

    /**
     * Exibir lista de logs de atividade
     */
    public function index(Request $request): View
    {
        $query = ActivityLog::forProfessional($this->professionalId)
            ->with(['appointment', 'customer', 'user'])
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('action')) {
            $query->byAction($request->action);
        }

        if ($request->filled('entity_type')) {
            $query->byEntity($request->entity_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('appointment', function ($appointmentQuery) use ($search) {
                      $appointmentQuery->whereHas('service', function ($serviceQuery) use ($search) {
                          $serviceQuery->where('name', 'like', "%{$search}%");
                      });
                  });
            });
        }

        $logs = $query->paginate(20);

        // Estatísticas
        $stats = [
            'total_logs' => ActivityLog::forProfessional($this->professionalId)->count(),
            'today_logs' => ActivityLog::forProfessional($this->professionalId)
                ->whereDate('created_at', today())->count(),
            'appointments_created' => ActivityLog::forProfessional($this->professionalId)
                ->byAction('created')->byEntity('appointment')->count(),
            'appointments_cancelled' => ActivityLog::forProfessional($this->professionalId)
                ->byAction('cancelled')->byEntity('appointment')->count(),
            'payments_received' => ActivityLog::forProfessional($this->professionalId)
                ->byAction('payment_received')->count(),
        ];

        // Filtros disponíveis
        $actions = ActivityLog::forProfessional($this->professionalId)
            ->distinct()
            ->pluck('action')
            ->mapWithKeys(function ($action) {
                $actionNames = [
                    'created' => 'Criado',
                    'updated' => 'Atualizado',
                    'cancelled' => 'Cancelado',
                    'confirmed' => 'Confirmado',
                    'completed' => 'Concluído',
                    'no_show' => 'Não Compareceu',
                    'rescheduled' => 'Reagendado',
                    'deleted' => 'Excluído',
                    'payment_received' => 'Pagamento Recebido',
                    'feedback_sent' => 'Feedback Enviado',
                ];
                return [$action => $actionNames[$action] ?? ucfirst($action)];
            });

        $entityTypes = ActivityLog::forProfessional($this->professionalId)
            ->distinct()
            ->pluck('entity_type')
            ->mapWithKeys(function ($entityType) {
                $entityNames = [
                    'appointment' => 'Agendamento',
                    'customer' => 'Cliente',
                    'service' => 'Serviço',
                    'professional' => 'Profissional',
                    'payment' => 'Pagamento',
                ];
                return [$entityType => $entityNames[$entityType] ?? ucfirst($entityType)];
            });

        return view('panel.activity-logs.index', compact(
            'logs',
            'stats',
            'actions',
            'entityTypes'
        ));
    }

    /**
     * Exibir detalhes de um log específico
     */
    public function show(ActivityLog $activityLog): View
    {
        // Verificar se o log pertence ao profissional
        if ($activityLog->professional_id !== $this->professionalId) {
            abort(403, 'Acesso negado');
        }

        $activityLog->load(['appointment.service', 'customer', 'user']);

        return view('panel.activity-logs.show', compact('activityLog'));
    }

    /**
     * Exportar logs para CSV
     */
    public function export(Request $request)
    {
        $query = ActivityLog::forProfessional($this->professionalId)
            ->with(['appointment.service', 'customer', 'user'])
            ->orderBy('created_at', 'desc');

        // Aplicar mesmos filtros do index
        if ($request->filled('action')) {
            $query->byAction($request->action);
        }

        if ($request->filled('entity_type')) {
            $query->byEntity($request->entity_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->get();

        $filename = 'logs_atividade_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');

            // Cabeçalho do CSV
            fputcsv($file, [
                'Data/Hora',
                'Ação',
                'Entidade',
                'Cliente',
                'Serviço',
                'Descrição',
                'IP',
                'Usuário'
            ]);

            // Dados
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('d/m/Y H:i:s'),
                    $log->action_name,
                    $log->entity_name,
                    $log->customer->name ?? '-',
                    $log->appointment->service->name ?? '-',
                    $log->formatted_description,
                    $log->ip_address ?? '-',
                    $log->user->name ?? 'Sistema'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Obter estatísticas para dashboard
     */
    public function getStats(Request $request)
    {
        $days = $request->get('days', 30);
        
        $stats = [
            'total_logs' => ActivityLog::forProfessional($this->professionalId)
                ->recent($days)->count(),
            'appointments_created' => ActivityLog::forProfessional($this->professionalId)
                ->recent($days)->byAction('created')->byEntity('appointment')->count(),
            'appointments_cancelled' => ActivityLog::forProfessional($this->professionalId)
                ->recent($days)->byAction('cancelled')->byEntity('appointment')->count(),
            'payments_received' => ActivityLog::forProfessional($this->professionalId)
                ->recent($days)->byAction('payment_received')->count(),
        ];

        // Logs por dia (últimos 7 dias)
        $logsByDay = ActivityLog::forProfessional($this->professionalId)
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // Logs por ação (últimos 30 dias)
        $logsByAction = ActivityLog::forProfessional($this->professionalId)
            ->recent(30)
            ->selectRaw('action, COUNT(*) as count')
            ->groupBy('action')
            ->get()
            ->pluck('count', 'action');

        return response()->json([
            'stats' => $stats,
            'logs_by_day' => $logsByDay,
            'logs_by_action' => $logsByAction,
        ]);
    }
}