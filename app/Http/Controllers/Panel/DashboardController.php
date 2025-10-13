<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Por enquanto usando professional_id = 1 (single-tenant)
        $professionalId = 1;

        $stats = [
            'total_appointments' => Appointment::where('professional_id', $professionalId)->count(),
            'pending_appointments' => Appointment::where('professional_id', $professionalId)
                ->where('status', 'pending')->count(),
            'total_customers' => Customer::where('professional_id', $professionalId)->count(),
            'total_services' => Service::where('professional_id', $professionalId)->count(),
        ];

        // Próximos agendamentos (hoje e futuro)
        $upcomingAppointments = Appointment::where('professional_id', $professionalId)
            ->where('start_time', '>=', now())
            ->with(['customer', 'service'])
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        // Agendamentos por mês (últimos 6 meses)
        $monthlyStats = Appointment::where('professional_id', $professionalId)
            ->where('start_time', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(start_time, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('panel.dashboard', compact('stats', 'upcomingAppointments', 'monthlyStats'));
    }
}
