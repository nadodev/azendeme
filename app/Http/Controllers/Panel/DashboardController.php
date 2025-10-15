<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\FinancialTransaction;
use App\Models\CashRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $professionalId;
    public function __construct()
    {
        $this->professionalId = auth()->user()->id;
    }

    public function index()
    {
        // Por enquanto usando professional_id = 1 (single-tenant)
        $professionalId = $this->professionalId;

        // Estatísticas de Agendamentos
        $stats = [
            'total_appointments' => Appointment::where('professional_id', $professionalId)->count(),
            'pending_appointments' => Appointment::where('professional_id', $professionalId)
                ->where('status', 'pending')->count(),
            'confirmed_appointments' => Appointment::where('professional_id', $professionalId)
                ->where('status', 'confirmed')->count(),
            'completed_appointments' => Appointment::where('professional_id', $professionalId)
                ->where('status', 'completed')->count(),
            'total_customers' => Customer::where('professional_id', $professionalId)->count(),
            'total_services' => Service::where('professional_id', $professionalId)->count(),
        ];

        // Estatísticas Financeiras do Mês Atual
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $monthlyIncome = FinancialTransaction::where('professional_id', $professionalId)
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->where('type', 'income')
            ->where('status', 'completed')
            ->sum('amount');
            
        $monthlyExpense = FinancialTransaction::where('professional_id', $professionalId)
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->where('type', 'expense')
            ->where('status', 'completed')
            ->sum('amount');
            
        $monthlyProfit = $monthlyIncome - $monthlyExpense;

        // Receita de Hoje
        $todayIncome = FinancialTransaction::where('professional_id', $professionalId)
            ->whereDate('transaction_date', today())
            ->where('type', 'income')
            ->where('status', 'completed')
            ->sum('amount');

        // Caixa de Hoje
        $todayCashRegister = CashRegister::where('professional_id', $professionalId)
            ->whereDate('date', today())
            ->first();

        $financialStats = [
            'monthly_income' => $monthlyIncome,
            'monthly_expense' => $monthlyExpense,
            'monthly_profit' => $monthlyProfit,
            'today_income' => $todayIncome,
            'cash_register' => $todayCashRegister,
        ];

        // Próximos agendamentos (hoje e futuro)
        $upcomingAppointments = Appointment::where('professional_id', $professionalId)
            ->where('start_time', '>=', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['customer', 'service'])
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        // Agendamentos por mês (últimos 6 meses)
        $monthlyAppointments = Appointment::where('professional_id', $professionalId)
            ->where('start_time', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(start_time, "%b/%Y") as month'),
                DB::raw('DATE_FORMAT(start_time, "%Y-%m") as month_order'),
                DB::raw('count(*) as total')
            )
            ->groupBy('month', 'month_order')
            ->orderBy('month_order')
            ->get();

        // Receita por mês (últimos 6 meses)
        $monthlyRevenue = FinancialTransaction::where('professional_id', $professionalId)
            ->where('transaction_date', '>=', now()->subMonths(6))
            ->where('type', 'income')
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE_FORMAT(transaction_date, "%b/%Y") as month'),
                DB::raw('DATE_FORMAT(transaction_date, "%Y-%m") as month_order'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month', 'month_order')
            ->orderBy('month_order')
            ->get();

        // Top 5 serviços mais agendados
        $topServices = Service::where('professional_id', $professionalId)
            ->withCount(['appointments' => function($query) {
                $query->whereIn('status', ['confirmed', 'completed']);
            }])
            ->orderBy('appointments_count', 'desc')
            ->limit(5)
            ->get();

        return view('panel.dashboard', compact(
            'stats', 
            'financialStats', 
            'upcomingAppointments', 
            'monthlyAppointments',
            'monthlyRevenue',
            'topServices'
        ));
    }
}
