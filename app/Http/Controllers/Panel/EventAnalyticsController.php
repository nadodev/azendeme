<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCost;
use App\Models\EventPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        $start = Carbon::parse($request->get('start_date', Carbon::now()->startOfMonth()->toDateString()))->startOfDay();
        $end = Carbon::parse($request->get('end_date', Carbon::now()->endOfMonth()->toDateString()))->endOfDay();

        // Base query scoped to professional and date range
        $eventsQuery = Event::where('professional_id', $professional->id)
            ->whereBetween('event_date', [$start->toDateString(), $end->toDateString()]);

        $paymentsQuery = EventPayment::whereHas('invoice.event', function($q) use ($professional) {
                $q->where('professional_id', $professional->id);
            })
            ->whereBetween('payment_date', [$start, $end])
            ->where('status', 'confirmado');

        $costsQuery = EventCost::whereHas('event', function($q) use ($professional) {
                $q->where('professional_id', $professional->id);
            })
            ->whereBetween('cost_date', [$start->toDateString(), $end->toDateString()]);

        // Metrics
        $totalEvents = (clone $eventsQuery)->count();
        $completedEvents = (clone $eventsQuery)->where('status', 'concluido')->count();

        $totalRevenue = (clone $paymentsQuery)->sum('amount');
        $activeClients = (clone $eventsQuery)->distinct('customer_id')->count('customer_id');

        // Popular hours (group by hour)
        $popularHours = (clone $eventsQuery)
            ->selectRaw('HOUR(start_time) as hour, COUNT(*) as total')
            ->groupBy('hour')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Top services by count using event_services if exists; fallback to event type count
        $topEventTypes = (clone $eventsQuery)
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->orderBy('total', 'desc')
            ->limit(6)
            ->get();

        // Financial summary
        $totalCosts = (clone $costsQuery)->sum('amount');
        $netProfit = round($totalRevenue - $totalCosts, 2);

        // Most used payment methods
        $paymentMethods = (clone $paymentsQuery)
            ->selectRaw('payment_method, COUNT(*) as total, SUM(amount) as amount')
            ->groupBy('payment_method')
            ->orderBy('total', 'desc')
            ->get();

        return view('panel.events.analytics.index', compact(
            'start', 'end', 'totalEvents', 'completedEvents', 'totalRevenue',
            'activeClients', 'popularHours', 'topEventTypes', 'totalCosts', 'netProfit', 'paymentMethods'
        ));
    }
}


