<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $professionalId = 1;

        // Período (padrão: últimos 30 dias)
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Total de agendamentos por status
        $appointmentsByStatus = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Serviços mais procurados
        $topServices = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->select('service_id', DB::raw('count(*) as total'))
            ->groupBy('service_id')
            ->with('service')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Taxa de cancelamento
        $totalAppointments = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->count();

        $cancelledAppointments = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->where('status', 'cancelled')
            ->count();

        $cancellationRate = $totalAppointments > 0 
            ? round(($cancelledAppointments / $totalAppointments) * 100, 2) 
            : 0;

        // Horários de pico (por hora do dia)
        $peakHours = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->select(DB::raw('HOUR(start_time) as hour'), DB::raw('count(*) as total'))
            ->groupBy('hour')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Receita estimada (baseado no preço dos serviços)
        $estimatedRevenue = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->whereIn('status', ['confirmed', 'completed'])
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->sum('services.price');

        return view('panel.relatorios', compact(
            'appointmentsByStatus',
            'topServices',
            'cancellationRate',
            'peakHours',
            'estimatedRevenue',
            'startDate',
            'endDate',
            'totalAppointments'
        ));
    }
}
