<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Service;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class FinancialReportController extends Controller
{
    private int $professionalId = 1; // Hardcoded por enquanto

    /**
     * Dashboard Financeiro Principal
     */
    public function dashboard(Request $request): View
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        // Receita total no período
        $totalRevenue = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('payments.created_at', [$dateFrom, $dateTo])
            ->sum('amount');

        // Receita por método de pagamento
        $revenueByPaymentMethod = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('payments.created_at', [$dateFrom, $dateTo])
            ->join('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.id')
            ->selectRaw('payment_methods.name, SUM(payments.amount) as total, COUNT(*) as count')
            ->groupBy('payment_methods.id', 'payment_methods.name')
            ->get();

        // Receita por serviço
        $revenueByService = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('payments.created_at', [$dateFrom, $dateTo])
            ->join('appointments', 'payments.appointment_id', '=', 'appointments.id')
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->selectRaw('services.name, SUM(payments.amount) as total, COUNT(*) as count')
            ->groupBy('services.id', 'services.name')
            ->orderBy('total', 'desc')
            ->get();

        // Receita mensal (últimos 12 meses)
        $monthlyRevenue = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->where('payments.created_at', '>=', now()->subMonths(12))
            ->selectRaw('DATE_FORMAT(payments.created_at, "%Y-%m") as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Comparação com período anterior
        $previousPeriodStart = Carbon::parse($dateFrom)->subDays(Carbon::parse($dateTo)->diffInDays(Carbon::parse($dateFrom)))->format('Y-m-d');
        $previousPeriodEnd = Carbon::parse($dateFrom)->subDay()->format('Y-m-d');

        $previousRevenue = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])
            ->sum('amount');

        $revenueGrowth = $previousRevenue > 0 
            ? round((($totalRevenue - $previousRevenue) / $previousRevenue) * 100, 2)
            : 0;

        // Estatísticas gerais
        $stats = [
            'total_revenue' => $totalRevenue,
            'total_appointments' => Appointment::where('professional_id', $this->professionalId)
                ->whereBetween('start_time', [$dateFrom, $dateTo])
                ->where('status', 'completed')
                ->count(),
            'average_ticket' => $totalRevenue > 0 ? $totalRevenue / max(1, $revenueByPaymentMethod->sum('count')) : 0,
            'revenue_growth' => $revenueGrowth,
            'previous_revenue' => $previousRevenue,
        ];

        return view('panel.reports.financial.dashboard', compact(
            'stats',
            'revenueByPaymentMethod',
            'revenueByService',
            'monthlyRevenue',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Relatório de Pagamentos por Método
     */
    public function paymentMethods(Request $request): View
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        $payments = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('payments.created_at', [$dateFrom, $dateTo])
            ->with(['appointment.service', 'appointment.customer', 'paymentMethod'])
            ->orderBy('payments.created_at', 'desc')
            ->paginate(20);

        $summary = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('payments.created_at', [$dateFrom, $dateTo])
            ->join('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.id')
            ->selectRaw('
                payment_methods.name,
                SUM(payments.amount) as total_amount,
                COUNT(*) as total_count,
                AVG(payments.amount) as average_amount
            ')
            ->groupBy('payment_methods.id', 'payment_methods.name')
            ->get();

        return view('panel.reports.financial.payment-methods', compact(
            'payments',
            'summary',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Relatório de Receita por Serviço
     */
    public function revenueByService(Request $request): View
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        $services = Service::where('professional_id', $this->professionalId)
            ->withCount(['appointments as completed_appointments' => function ($query) use ($dateFrom, $dateTo) {
                $query->where('status', 'completed')
                      ->whereBetween('start_time', [$dateFrom, $dateTo]);
            }])
            ->withSum(['appointments as total_revenue' => function ($query) use ($dateFrom, $dateTo) {
                $query->where('status', 'completed')
                      ->whereBetween('start_time', [$dateFrom, $dateTo]);
            }], 'total_price')
            ->get();

        // Calcular estatísticas adicionais
        $services->each(function ($service) use ($dateFrom, $dateTo) {
            $service->average_revenue = $service->completed_appointments > 0 
                ? $service->total_revenue / $service->completed_appointments 
                : 0;
        });

        $totalRevenue = $services->sum('total_revenue');
        $totalAppointments = $services->sum('completed_appointments');

        return view('panel.reports.financial.revenue-by-service', compact(
            'services',
            'totalRevenue',
            'totalAppointments',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Relatório de Receita Mensal
     */
    public function monthlyRevenue(Request $request): View
    {
        $year = $request->get('year', now()->year);
        
        $monthlyData = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereYear('created_at', $year)
            ->selectRaw('
                MONTH(created_at) as month,
                SUM(amount) as total_revenue,
                COUNT(*) as total_payments,
                AVG(amount) as average_ticket
            ')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Preencher meses sem dados
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $monthlyData->firstWhere('month', $i);
            $months[] = [
                'month' => $i,
                'month_name' => Carbon::create()->month($i)->format('F'),
                'year' => $year,
                'total_revenue' => $monthData->total_revenue ?? 0,
                'total_payments' => $monthData->total_payments ?? 0,
                'average_ticket' => $monthData->average_ticket ?? 0,
            ];
        }

        $yearlyTotal = $monthlyData->sum('total_revenue');
        $yearlyPayments = $monthlyData->sum('total_payments');
        $yearlyAverage = $yearlyPayments > 0 ? $yearlyTotal / $yearlyPayments : 0;

        return view('panel.reports.financial.monthly-revenue', compact(
            'months',
            'yearlyTotal',
            'yearlyPayments',
            'yearlyAverage',
            'year'
        ));
    }

    /**
     * API para dados do dashboard
     */
    public function getDashboardData(Request $request): JsonResponse
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        // Receita por dia (últimos 30 dias)
        $dailyRevenue = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        // Top 5 serviços mais rentáveis
        $topServices = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->join('appointments', 'payments.appointment_id', '=', 'appointments.id')
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->selectRaw('services.name, SUM(payments.amount) as total')
            ->groupBy('services.id', 'services.name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Receita por método de pagamento
        $paymentMethods = Payment::whereHas('appointment', function ($query) {
                $query->where('professional_id', $this->professionalId);
            })
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->join('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.id')
            ->selectRaw('payment_methods.name, SUM(payments.amount) as total')
            ->groupBy('payment_methods.id', 'payment_methods.name')
            ->get();

        return response()->json([
            'daily_revenue' => $dailyRevenue,
            'top_services' => $topServices,
            'payment_methods' => $paymentMethods,
        ]);
    }

    /**
     * Exportar relatório financeiro
     */
    public function export(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));
        $type = $request->get('type', 'payments');

        $filename = "relatorio_financeiro_{$type}_" . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($type, $dateFrom, $dateTo) {
            $file = fopen('php://output', 'w');

            if ($type === 'payments') {
                // Cabeçalho para relatório de pagamentos
                fputcsv($file, [
                    'Data',
                    'Cliente',
                    'Serviço',
                    'Método de Pagamento',
                    'Valor',
                    'Status'
                ]);

                // Dados de pagamentos
                $payments = Payment::whereHas('appointment', function ($query) {
                        $query->where('professional_id', $this->professionalId);
                    })
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->with(['appointment.service', 'appointment.customer', 'paymentMethod'])
                    ->get();

                foreach ($payments as $payment) {
                    fputcsv($file, [
                        $payment->created_at->format('d/m/Y H:i'),
                        $payment->appointment->customer->name,
                        $payment->appointment->service->name,
                        $payment->paymentMethod->name,
                        'R$ ' . number_format($payment->amount, 2, ',', '.'),
                        'Pago'
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}