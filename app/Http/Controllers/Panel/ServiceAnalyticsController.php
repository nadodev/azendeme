<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class ServiceAnalyticsController extends Controller
{
    protected $professionalId;

    public function __construct()
    {
        $this->professionalId = auth()->user()->id;
    }


    /**
     * Dashboard de Analytics de Serviços
     */
    public function dashboard(Request $request): View
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        // Serviços mais agendados
        $mostBookedServices = Service::where('professional_id', $this->professionalId)
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
            ->get();

        // Calcular taxas de comparecimento e cancelamento
        $mostBookedServices->each(function ($service) {
            $total = $service->total_appointments;
            $service->attendance_rate = $total > 0 ? round(($service->completed_appointments / $total) * 100, 2) : 0;
            $service->cancellation_rate = $total > 0 ? round(($service->cancelled_appointments / $total) * 100, 2) : 0;
            $service->no_show_rate = $total > 0 ? round(($service->no_show_appointments / $total) * 100, 2) : 0;
        });

        // Estatísticas gerais
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

        $stats = [
            'total_appointments' => $totalAppointments,
            'completed_appointments' => $completedAppointments,
            'cancelled_appointments' => $cancelledAppointments,
            'no_show_appointments' => $noShowAppointments,
            'attendance_rate' => $totalAppointments > 0 ? round(($completedAppointments / $totalAppointments) * 100, 2) : 0,
            'cancellation_rate' => $totalAppointments > 0 ? round(($cancelledAppointments / $totalAppointments) * 100, 2) : 0,
            'no_show_rate' => $totalAppointments > 0 ? round(($noShowAppointments / $totalAppointments) * 100, 2) : 0,
        ];

        // Agendamentos por dia da semana
        $appointmentsByDay = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->selectRaw('DAYOFWEEK(start_time) as day_of_week, COUNT(*) as count')
            ->groupBy('day_of_week')
            ->get()
            ->pluck('count', 'day_of_week');

        // Agendamentos por hora
        $appointmentsByHour = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->selectRaw('HOUR(start_time) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour');

        return view('panel.reports.services.dashboard', compact(
            'mostBookedServices',
            'stats',
            'appointmentsByDay',
            'appointmentsByHour',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Relatório de Serviços Mais Agendados
     */
    public function mostBookedServices(Request $request): View
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        $services = Service::where('professional_id', $this->professionalId)
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
            ->get();

        // Calcular estatísticas
        $services->each(function ($service) {
            $total = $service->total_appointments;
            $service->attendance_rate = $total > 0 ? round(($service->completed_appointments / $total) * 100, 2) : 0;
            $service->cancellation_rate = $total > 0 ? round(($service->cancelled_appointments / $total) * 100, 2) : 0;
            $service->no_show_rate = $total > 0 ? round(($service->no_show_appointments / $total) * 100, 2) : 0;
        });

        $totalAppointments = $services->sum('total_appointments');

        return view('panel.reports.services.most-booked', compact(
            'services',
            'totalAppointments',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Relatório de Taxa de Comparecimento
     */
    public function attendanceRate(Request $request): View
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        // Taxa de comparecimento por serviço
        $services = Service::where('professional_id', $this->professionalId)
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
            ->get();

        $services->each(function ($service) {
            $total = $service->total_appointments;
            $service->attendance_rate = $total > 0 ? round(($service->completed_appointments / $total) * 100, 2) : 0;
            $service->cancellation_rate = $total > 0 ? round(($service->cancelled_appointments / $total) * 100, 2) : 0;
            $service->no_show_rate = $total > 0 ? round(($service->no_show_appointments / $total) * 100, 2) : 0;
        });

        // Taxa de comparecimento mensal (últimos 12 meses)
        $monthlyAttendance = Appointment::where('professional_id', $this->professionalId)
            ->where('start_time', '>=', now()->subMonths(12))
            ->selectRaw('
                DATE_FORMAT(start_time, "%Y-%m") as month,
                COUNT(*) as total_appointments,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_appointments,
                SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled_appointments,
                SUM(CASE WHEN status = "no-show" THEN 1 ELSE 0 END) as no_show_appointments
            ')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyAttendance->each(function ($month) {
            $total = $month->total_appointments;
            $month->attendance_rate = $total > 0 ? round(($month->completed_appointments / $total) * 100, 2) : 0;
            $month->cancellation_rate = $total > 0 ? round(($month->cancelled_appointments / $total) * 100, 2) : 0;
            $month->no_show_rate = $total > 0 ? round(($month->no_show_appointments / $total) * 100, 2) : 0;
        });

        // Estatísticas gerais
        $totalAppointments = $services->sum('total_appointments');
        $totalCompleted = $services->sum('completed_appointments');
        $totalCancelled = $services->sum('cancelled_appointments');
        $totalNoShow = $services->sum('no_show_appointments');

        $stats = [
            'total_appointments' => $totalAppointments,
            'attendance_rate' => $totalAppointments > 0 ? round(($totalCompleted / $totalAppointments) * 100, 2) : 0,
            'cancellation_rate' => $totalAppointments > 0 ? round(($totalCancelled / $totalAppointments) * 100, 2) : 0,
            'no_show_rate' => $totalAppointments > 0 ? round(($totalNoShow / $totalAppointments) * 100, 2) : 0,
        ];

        return view('panel.reports.services.attendance-rate', compact(
            'services',
            'monthlyAttendance',
            'stats',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Relatório de Clientes Mais Frequentes
     */
    public function topCustomers(Request $request): View
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        $customers = Customer::where('professional_id', $this->professionalId)
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
            ->limit(20)
            ->get();

        $customers->each(function ($customer) {
            $total = $customer->total_appointments;
            $customer->attendance_rate = $total > 0 ? round(($customer->completed_appointments / $total) * 100, 2) : 0;
            $customer->cancellation_rate = $total > 0 ? round(($customer->cancelled_appointments / $total) * 100, 2) : 0;
            $customer->no_show_rate = $total > 0 ? round(($customer->no_show_appointments / $total) * 100, 2) : 0;
        });

        return view('panel.reports.services.top-customers', compact(
            'customers',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * API para dados de analytics
     */
    public function getAnalyticsData(Request $request): JsonResponse
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->endOfMonth()->format('Y-m-d'));

        // Agendamentos por status
        $appointmentsByStatus = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Top 5 serviços mais agendados
        $topServices = Service::where('professional_id', $this->professionalId)
            ->withCount(['appointments as total_appointments' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('start_time', [$dateFrom, $dateTo]);
            }])
            ->orderBy('total_appointments', 'desc')
            ->limit(5)
            ->get();

        // Agendamentos por dia da semana
        $appointmentsByDay = Appointment::where('professional_id', $this->professionalId)
            ->whereBetween('start_time', [$dateFrom, $dateTo])
            ->selectRaw('DAYOFWEEK(start_time) as day_of_week, COUNT(*) as count')
            ->groupBy('day_of_week')
            ->get()
            ->pluck('count', 'day_of_week');

        return response()->json([
            'appointments_by_status' => $appointmentsByStatus,
            'top_services' => $topServices,
            'appointments_by_day' => $appointmentsByDay,
        ]);
    }
}