<?php

namespace App\Services;

use App\Models\{Appointment, Service, Customer, FinancialTransaction};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Calcula métricas do dashboard
     */
    public function getDashboardMetrics($professionalId, $startDate = null, $endDate = null)
    {
        $startDate = $startDate ? Carbon::parse($startDate) : Carbon::now()->startOfMonth();
        $endDate = $endDate ? Carbon::parse($endDate) : Carbon::now()->endOfMonth();

        return [
            'period' => [
                'start' => $startDate->format('d/m/Y'),
                'end' => $endDate->format('d/m/Y'),
            ],
            'appointments' => $this->getAppointmentMetrics($professionalId, $startDate, $endDate),
            'revenue' => $this->getRevenueMetrics($professionalId, $startDate, $endDate),
            'services' => $this->getServiceMetrics($professionalId, $startDate, $endDate),
            'customers' => $this->getCustomerMetrics($professionalId, $startDate, $endDate),
            'schedule' => $this->getScheduleMetrics($professionalId, $startDate, $endDate),
        ];
    }

    /**
     * Métricas de agendamentos
     */
    private function getAppointmentMetrics($professionalId, $startDate, $endDate)
    {
        $appointments = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->get();

        $total = $appointments->count();
        $completed = $appointments->where('status', 'completed')->count();
        $cancelled = $appointments->where('status', 'cancelled')->count();
        $noShow = $appointments->where('status', 'no-show')->count();
        $pending = $appointments->where('status', 'pending')->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'cancelled' => $cancelled,
            'no_show' => $noShow,
            'pending' => $pending,
            'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
            'no_show_rate' => $total > 0 ? round(($noShow / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Métricas de receita
     */
    private function getRevenueMetrics($professionalId, $startDate, $endDate)
    {
        $transactions = FinancialTransaction::where('professional_id', $professionalId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->get();


        $income = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');
        $profit = $income - $expense;

        return [
            'income' => $income,
            'expense' => $expense,
            'profit' => $profit,
            'transactions_count' => $transactions->count(),
            'avg_transaction' => $transactions->count() > 0 ? $income / $transactions->where('type', 'income')->count() : 0,
        ];
    }

    /**
     * Serviços mais vendidos
     */
    private function getServiceMetrics($professionalId, $startDate, $endDate)
    {
        $topServices = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select('service_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(COALESCE(total_price, 0)) as revenue'))
            ->groupBy('service_id')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->with('service')
            ->get()
            ->map(function($item) {
                return [
                    'service_name' => $item->service->name ?? 'N/A',
                    'count' => $item->count,
                    'revenue' => $item->revenue,
                ];
            });

        return $topServices;
    }

    /**
     * Métricas de clientes
     */
    private function getCustomerMetrics($professionalId, $startDate, $endDate)
    {
        $newCustomers = Customer::where('professional_id', $professionalId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $returningCustomers = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->select('customer_id', DB::raw('COUNT(*) as visit_count'))
            ->groupBy('customer_id')
            ->having('visit_count', '>', 1)
            ->count();

        return [
            'new' => $newCustomers,
            'returning' => $returningCustomers,
            'total_active' => $newCustomers + $returningCustomers,
        ];
    }

    /**
     * Análise de ocupação da agenda
     */
    private function getScheduleMetrics($professionalId, $startDate, $endDate)
    {
        // Horários mais populares
        $popularTimes = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->select(DB::raw('HOUR(start_time) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                return [
                    'hour' => $item->hour . ':00',
                    'count' => $item->count,
                ];
            });

        // Dias da semana mais ocupados
        $popularDays = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->select(DB::raw('DAYOFWEEK(start_time) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy('day')
            ->orderBy('count', 'desc')
            ->get()
            ->map(function($item) {
                $days = ['', 'Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
                return [
                    'day' => $days[$item->day] ?? 'N/A',
                    'count' => $item->count,
                ];
            });

        return [
            'popular_times' => $popularTimes,
            'popular_days' => $popularDays,
        ];
    }

    /**
     * Exporta dados para relatório
     */
    public function exportReport($professionalId, $type, $startDate, $endDate, $format = 'pdf')
    {
        $data = $this->getDashboardMetrics($professionalId, $startDate, $endDate);
        
        // Aqui você pode adicionar lógica para gerar PDF ou Excel
        return $data;
    }
}

