<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventScheduleController extends Controller
{
    /**
     * Display the event schedule.
     */
    public function index(Request $request)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        $view = $request->get('view', 'calendar'); // calendar ou list
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $type = $request->get('type', '');
        $status = $request->get('status', '');

        // Construir query base
        $query = Event::where('professional_id', $professional->id);

        // Aplicar filtros
        if ($type) {
            $query->where('type', $type);
        }

        if ($status) {
            $query->where('status', $status);
        }

        // Para visualização em calendário
        if ($view === 'calendar') {
            $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();
            
            $query->whereBetween('event_date', [$startOfMonth, $endOfMonth]);
        }

        $events = $query->with(['customer', 'services.equipment', 'serviceOrders'])
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        // Dados para o calendário
        $calendarData = $this->getCalendarData($events, $month, $year);

        // Estatísticas
        $stats = $this->getStats($professional->id, $month, $year);

        // Opções de filtro
        $eventTypes = Event::where('professional_id', $professional->id)
            ->distinct()
            ->pluck('type')
            ->map(function($type) {
                return [
                    'value' => $type,
                    'label' => ucfirst($type)
                ];
            });

        $eventStatuses = Event::where('professional_id', $professional->id)
            ->distinct()
            ->pluck('status')
            ->map(function($status) {
                return [
                    'value' => $status,
                    'label' => ucfirst($status)
                ];
            });

        return view('panel.events.schedule.index', compact(
            'events',
            'calendarData',
            'stats',
            'view',
            'month',
            'year',
            'type',
            'status',
            'eventTypes',
            'eventStatuses'
        ));
    }

    /**
     * Get calendar data for the month.
     */
    private function getCalendarData($events, $month, $year)
    {
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();
        
        // Primeiro dia da semana do mês
        $firstDayOfWeek = $startOfMonth->dayOfWeek;
        
        // Último dia da semana do mês
        $lastDayOfWeek = $endOfMonth->dayOfWeek;
        
        // Dias do mês anterior para completar a primeira semana
        $prevMonthDays = [];
        if ($firstDayOfWeek > 0) {
            $prevMonth = $startOfMonth->copy()->subMonth();
            $lastDayPrevMonth = $prevMonth->endOfMonth()->day;
            
            for ($i = $firstDayOfWeek - 1; $i >= 0; $i--) {
                $prevMonthDays[] = [
                    'day' => $lastDayPrevMonth - $i,
                    'is_current_month' => false,
                    'date' => $prevMonth->copy()->day($lastDayPrevMonth - $i),
                    'events' => []
                ];
            }
        }
        
        // Dias do mês atual
        $currentMonthDays = [];
        $daysInMonth = $startOfMonth->daysInMonth;
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $startOfMonth->copy()->day($day);
            $dayEvents = $events->filter(function($event) use ($date) {
                return $event->event_date->format('Y-m-d') === $date->format('Y-m-d');
            });
            
            $currentMonthDays[] = [
                'day' => $day,
                'is_current_month' => true,
                'date' => $date,
                'events' => $dayEvents,
                'is_today' => $date->isToday(),
                'is_past' => $date->isPast() && !$date->isToday()
            ];
        }
        
        // Dias do próximo mês para completar a última semana
        $nextMonthDays = [];
        $remainingDays = 6 - $lastDayOfWeek;
        
        if ($remainingDays > 0) {
            $nextMonth = $endOfMonth->copy()->addMonth();
            
            for ($day = 1; $day <= $remainingDays; $day++) {
                $nextMonthDays[] = [
                    'day' => $day,
                    'is_current_month' => false,
                    'date' => $nextMonth->copy()->day($day),
                    'events' => []
                ];
            }
        }
        
        return [
            'prev_month_days' => $prevMonthDays,
            'current_month_days' => $currentMonthDays,
            'next_month_days' => $nextMonthDays,
            'month_name' => $startOfMonth->format('F Y'),
            'month_number' => $month,
            'year' => $year
        ];
    }

    /**
     * Get statistics for the month.
     */
    private function getStats($professionalId, $month, $year)
    {
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

        $events = Event::where('professional_id', $professionalId)
            ->whereBetween('event_date', [$startOfMonth, $endOfMonth]);

        return [
            'total_events' => $events->count(),
            'confirmed_events' => $events->where('status', 'confirmado')->count(),
            'pending_events' => $events->where('status', 'orcamento')->count(),
            'completed_events' => $events->where('status', 'concluido')->count(),
            'total_revenue' => $events->sum('final_value'),
        ];
    }

    /**
     * Get events for a specific date (AJAX).
     */
    public function getEventsForDate(Request $request)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            return response()->json(['error' => 'Profissional não encontrado'], 404);
        }

        $date = $request->get('date');
        if (!$date) {
            return response()->json(['error' => 'Data não fornecida'], 400);
        }

        $events = Event::where('professional_id', $professional->id)
            ->whereDate('event_date', $date)
            ->with(['customer', 'services.equipment', 'serviceOrders'])
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'events' => $events->map(function($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'customer' => $event->customer->name,
                    'type' => $event->type,
                    'status' => $event->status,
                    'start_time' => $event->start_time->format('H:i'),
                    'end_time' => $event->end_time->format('H:i'),
                    'location' => $event->address,
                    'value' => $event->final_value,
                    'has_service_order' => $event->serviceOrders->count() > 0,
                    'service_order_status' => $event->serviceOrders->first()?->status ?? null,
                ];
            })
        ]);
    }
}
