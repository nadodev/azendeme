<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class PerformanceDashboardController extends Controller
{
    private int $professionalId = 1; // Hardcoded por enquanto

    /**
     * Dashboard Geral de Desempenho
     */
    public function index(Request $request): View
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        // Métricas principais
        $metrics = $this->getMainMetrics($dateFrom, $dateTo);
        
        // Receita e crescimento
        $revenue = $this->getRevenueMetrics($dateFrom, $dateTo);
        
        // Performance de serviços
        $servicePerformance = $this->getServicePerformance($dateFrom, $dateTo);
        
        // Performance de clientes
        $customerPerformance = $this->getCustomerPerformance($dateFrom, $dateTo);
        
        // Tendências temporais
        $trends = $this->getTrends($dateFrom, $dateTo);
        
        // Alertas e insights
        $insights = $this->getInsights($dateFrom, $dateTo);

        return view('panel.dashboard.performance', compact(
            'metrics',
            'revenue',
            'servicePerformance',
            'customerPerformance',
            'trends',
            'insights',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Obter métricas principais
     */
    private function getMainMetrics(string $dateFrom, string $dateTo): array
    {
        $totalAppointments = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->count();

        $completedAppointments = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->where('status', 'completed')
            ->count();

        $cancelledAppointments = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->where('status', 'cancelled')
            ->count();

        $noShowAppointments = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->where('status', 'no-show')
            ->count();

        $totalRevenue = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('payments.created_at', [$dateFrom, $dateTo])
            ->sum('amount');

        $newCustomers = Customer::where('professional_id', $this->professionalId)
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();

        return [
            'total_appointments' => $totalAppointments,
            'completed_appointments' => $completedAppointments,
            'cancelled_appointments' => $cancelledAppointments,
            'no_show_appointments' => $noShowAppointments,
            'attendance_rate' => $totalAppointments > 0 ? round(($completedAppointments / $totalAppointments) * 100, 2) : 0,
            'cancellation_rate' => $totalAppointments > 0 ? round(($cancelledAppointments / $totalAppointments) * 100, 2) : 0,
            'no_show_rate' => $totalAppointments > 0 ? round(($noShowAppointments / $totalAppointments) * 100, 2) : 0,
            'total_revenue' => $totalRevenue,
            'average_ticket' => $completedAppointments > 0 ? round($totalRevenue / $completedAppointments, 2) : 0,
            'new_customers' => $newCustomers,
        ];
    }

    /**
     * Obter métricas de receita
     */
    private function getRevenueMetrics(string $dateFrom, string $dateTo): array
    {
        $currentRevenue = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->sum('amount');

        // Período anterior para comparação
        $periodDays = Carbon::parse($dateTo)->diffInDays(Carbon::parse($dateFrom));
        $previousStart = Carbon::parse($dateFrom)->subDays($periodDays)->format('Y-m-d');
        $previousEnd = Carbon::parse($dateFrom)->subDay()->format('Y-m-d');

        $previousRevenue = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->sum('amount');

        $revenueGrowth = $previousRevenue > 0 
            ? round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100, 2)
            : 0;

        // Receita por método de pagamento
        $revenueByPaymentMethod = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('payments.created_at', [$dateFrom, $dateTo])
            ->join('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.id')
            ->selectRaw('payment_methods.name, SUM(payments.amount) as total')
            ->groupBy('payment_methods.id', 'payment_methods.name')
            ->get();

        return [
            'current_revenue' => $currentRevenue,
            'previous_revenue' => $previousRevenue,
            'revenue_growth' => $revenueGrowth,
            'revenue_by_payment_method' => $revenueByPaymentMethod,
        ];
    }

    /**
     * Obter performance de serviços
     */
    private function getServicePerformance(string $dateFrom, string $dateTo): array
    {
        $services = Service::where('professional_id', $this->professionalId)
            ->withCount(['appointments as total_appointments' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('start_time', [$dateFrom, $dateTo]);
            }])
            ->withCount(['appointments as completed_appointments' => function ($query) use ($dateFrom, $dateTo) {
                $query->where('status', 'completed')
                      ->whereBetween('start_time', [$dateFrom, $dateTo]);
            }])
            ->withSum(['appointments as total_revenue' => function ($query) use ($dateFrom, $dateTo) {
                $query->where('status', 'completed')
                      ->whereBetween('start_time', [$dateFrom, $dateTo]);
            }], 'total_price')
            ->orderBy('total_appointments', 'desc')
            ->limit(5)
            ->get();

        $services->each(function ($service) {
            $service->attendance_rate = $service->total_appointments > 0 
                ? round(($service->completed_appointments / $service->total_appointments) * 100, 2) 
                : 0;
            $service->average_revenue = $service->completed_appointments > 0 
                ? round($service->total_revenue / $service->completed_appointments, 2) 
                : 0;
        });

        return $services->toArray();
    }

    /**
     * Obter performance de clientes
     */
    private function getCustomerPerformance(string $dateFrom, string $dateTo): array
    {
        $topCustomers = Customer::where('professional_id', $this->professionalId)
            ->withCount(['appointments as total_appointments' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('start_time', [$dateFrom, $dateTo]);
            }])
            ->withCount(['appointments as completed_appointments' => function ($query) use ($dateFrom, $dateTo) {
                $query->where('status', 'completed')
                      ->whereBetween('start_time', [$dateFrom, $dateTo]);
            }])
            ->withCount(['appointments as cancelled_appointments' => function ($query) use ($dateFrom, $dateTo) {
                $query->where('status', 'cancelled')
                      ->whereBetween('start_time', [$dateFrom, $dateTo]);
            }])
            ->withCount(['appointments as no_show_appointments' => function ($query) use ($dateFrom, $dateTo) {
                $query->where('status', 'no-show')
                      ->whereBetween('start_time', [$dateFrom, $dateTo]);
            }])
            ->orderBy('total_appointments', 'desc')
            ->limit(10)
            ->get();

        // Calcular taxas de comparecimento para cada cliente
        $topCustomers->each(function ($customer) {
            $total = $customer->total_appointments;
            $customer->attendance_rate = $total > 0 ? round(($customer->completed_appointments / $total) * 100, 2) : 0;
            $customer->cancellation_rate = $total > 0 ? round(($customer->cancelled_appointments / $total) * 100, 2) : 0;
            $customer->no_show_rate = $total > 0 ? round(($customer->no_show_appointments / $total) * 100, 2) : 0;
        });

        $customerStats = [
            'total_customers' => Customer::where('professional_id', $this->professionalId)->count(),
            'active_customers' => Customer::where('professional_id', $this->professionalId)
                ->whereHas('appointments', function ($query) use ($dateFrom, $dateTo) {
                    $query->whereBetween('start_time', [$dateFrom, $dateTo]);
                })
                ->count(),
            'new_customers' => Customer::where('professional_id', $this->professionalId)
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->count(),
        ];

        return [
            'top_customers' => $topCustomers->toArray(),
            'stats' => $customerStats,
        ];
    }

    /**
     * Obter tendências temporais
     */
    private function getTrends(string $dateFrom, string $dateTo): array
    {
        // Agendamentos por dia (últimos 30 dias)
        $appointmentsByDay = Appointment::where('professional_id', $this->professionalId)
            ->where('start_time', '>=', now()->subDays(30))
            ->selectRaw('DATE(start_time) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // Receita por dia (últimos 30 dias)
        $revenueByDay = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        // Agendamentos por hora do dia
        $appointmentsByHour = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->selectRaw('HOUR(start_time) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour');

        return [
            'appointments_by_day' => $appointmentsByDay,
            'revenue_by_day' => $revenueByDay,
            'appointments_by_hour' => $appointmentsByHour,
        ];
    }

    /**
     * Obter insights e alertas
     */
    private function getInsights(string $dateFrom, string $dateTo): array
    {
        $insights = [];

        // Taxa de cancelamento alta
        $totalAppointments = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->count();

        $cancelledAppointments = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->where('status', 'cancelled')
            ->count();

        $cancellationRate = $totalAppointments > 0 ? ($cancelledAppointments / $totalAppointments) * 100 : 0;

        if ($cancellationRate > 20) {
            $insights[] = [
                'type' => 'warning',
                'title' => 'Taxa de Cancelamento Alta',
                'message' => "Taxa de cancelamento está em {$cancellationRate}%. Considere implementar estratégias de retenção.",
                'icon' => '⚠️'
            ];
        }

        // Taxa de não comparecimento alta
        $noShowAppointments = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->where('status', 'no-show')
            ->count();

        $noShowRate = $totalAppointments > 0 ? ($noShowAppointments / $totalAppointments) * 100 : 0;

        if ($noShowRate > 15) {
            $insights[] = [
                'type' => 'warning',
                'title' => 'Taxa de Não Comparecimento Alta',
                'message' => "Taxa de não comparecimento está em {$noShowRate}%. Considere implementar lembretes automáticos.",
                'icon' => '🚫'
            ];
        }

        // Crescimento de receita positivo
        $currentRevenue = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->sum('amount');

        $periodDays = Carbon::parse($dateTo)->diffInDays(Carbon::parse($dateFrom));
        $previousStart = Carbon::parse($dateFrom)->subDays($periodDays)->format('Y-m-d');
        $previousEnd = Carbon::parse($dateFrom)->subDay()->format('Y-m-d');

        $previousRevenue = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->sum('amount');

        $revenueGrowth = $previousRevenue > 0 
            ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 
            : 0;

        if ($revenueGrowth > 10) {
            $insights[] = [
                'type' => 'success',
                'title' => 'Crescimento de Receita',
                'message' => "Receita cresceu {$revenueGrowth}% em relação ao período anterior. Parabéns!",
                'icon' => '📈'
            ];
        }

        // Poucos clientes novos
        $newCustomers = Customer::where('professional_id', $this->professionalId)
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();

        if ($newCustomers < 5 && $periodDays > 15) {
            $insights[] = [
                'type' => 'info',
                'title' => 'Poucos Clientes Novos',
                'message' => "Apenas {$newCustomers} clientes novos neste período. Considere estratégias de marketing.",
                'icon' => '👥'
            ];
        }

        return $insights;
    }

    /**
     * API para dados do dashboard
     */
    public function getDashboardData(Request $request): JsonResponse
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        $metrics = $this->getMainMetrics($dateFrom, $dateTo);
        $revenue = $this->getRevenueMetrics($dateFrom, $dateTo);
        $trends = $this->getTrends($dateFrom, $dateTo);

        return response()->json([
            'metrics' => $metrics,
            'revenue' => $revenue,
            'trends' => $trends,
        ]);
    }
}