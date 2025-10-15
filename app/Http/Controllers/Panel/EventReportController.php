<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventEquipment;
use App\Models\EventService;
use App\Models\EventInvoice;
use App\Models\EventPayment;
use App\Models\EventServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventReportController extends Controller
{
    /**
     * Display the reports index page.
     */
    public function index()
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        return view('panel.events.reports.index');
    }

    /**
     * Financial reports.
     */
    public function financial(Request $request)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        // Resumo financeiro geral
        $financialSummary = $this->getFinancialSummary($professional->id, $startDate, $endDate);
        
        // Faturas por status
        $invoicesByStatus = $this->getInvoicesByStatus($professional->id, $startDate, $endDate);
        
        // Pagamentos por método
        $paymentsByMethod = $this->getPaymentsByMethod($professional->id, $startDate, $endDate);
        
        // Evolução mensal
        $monthlyEvolution = $this->getMonthlyEvolution($professional->id, $startDate, $endDate);
        
        // Top clientes
        $topCustomers = $this->getTopCustomers($professional->id, $startDate, $endDate);

        return view('panel.events.reports.financial', compact(
            'financialSummary',
            'invoicesByStatus',
            'paymentsByMethod',
            'monthlyEvolution',
            'topCustomers',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Equipment usage reports.
     */
    public function equipment(Request $request)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        // Equipamentos mais usados
        $mostUsedEquipment = $this->getMostUsedEquipment($professional->id, $startDate, $endDate);
        
        // Receita por equipamento
        $revenueByEquipment = $this->getRevenueByEquipment($professional->id, $startDate, $endDate);
        
        // Horas utilizadas por equipamento
        $hoursByEquipment = $this->getHoursByEquipment($professional->id, $startDate, $endDate);

        return view('panel.events.reports.equipment', compact(
            'mostUsedEquipment',
            'revenueByEquipment',
            'hoursByEquipment',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Event type reports.
     */
    public function eventTypes(Request $request)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        // Eventos por tipo
        $eventsByType = $this->getEventsByType($professional->id, $startDate, $endDate);
        
        // Receita por tipo de evento
        $revenueByEventType = $this->getRevenueByEventType($professional->id, $startDate, $endDate);
        
        // Eventos por mês
        $eventsByMonth = $this->getEventsByMonth($professional->id, $startDate, $endDate);

        return view('panel.events.reports.event-types', compact(
            'eventsByType',
            'revenueByEventType',
            'eventsByMonth',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Payment method reports.
     */
    public function paymentMethods(Request $request)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        // Pagamentos por método
        $paymentsByMethod = $this->getPaymentsByMethod($professional->id, $startDate, $endDate);
        
        // Valor médio por método
        $averageByMethod = $this->getAverageByMethod($professional->id, $startDate, $endDate);
        
        // Evolução dos métodos de pagamento
        $methodEvolution = $this->getMethodEvolution($professional->id, $startDate, $endDate);

        return view('panel.events.reports.payment-methods', compact(
            'paymentsByMethod',
            'averageByMethod',
            'methodEvolution',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Get financial summary.
     */
    private function getFinancialSummary($professionalId, $startDate, $endDate)
    {
        $events = Event::where('professional_id', $professionalId)
            ->whereBetween('event_date', [$startDate, $endDate])
            ->with(['invoices', 'payments']);

        $totalEvents = $events->count();
        $totalInvoiced = $events->get()->sum('total_invoiced');
        $totalPaid = $events->get()->sum('total_paid');
        $totalPending = $totalInvoiced - $totalPaid;

        return [
            'total_events' => $totalEvents,
            'total_invoiced' => $totalInvoiced,
            'total_paid' => $totalPaid,
            'total_pending' => $totalPending,
            'average_per_event' => $totalEvents > 0 ? $totalInvoiced / $totalEvents : 0,
        ];
    }

    /**
     * Get invoices by status.
     */
    private function getInvoicesByStatus($professionalId, $startDate, $endDate)
    {
        return EventInvoice::whereHas('event', function($query) use ($professionalId, $startDate, $endDate) {
                $query->where('professional_id', $professionalId)
                      ->whereBetween('event_date', [$startDate, $endDate]);
            })
            ->select('status', DB::raw('count(*) as count'), DB::raw('sum(total) as total'))
            ->groupBy('status')
            ->get();
    }

    /**
     * Get payments by method.
     */
    private function getPaymentsByMethod($professionalId, $startDate, $endDate)
    {
        return EventPayment::whereHas('event', function($query) use ($professionalId, $startDate, $endDate) {
                $query->where('professional_id', $professionalId)
                      ->whereBetween('event_date', [$startDate, $endDate]);
            })
            ->where('status', 'confirmado')
            ->select('payment_method', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
            ->groupBy('payment_method')
            ->get();
    }

    /**
     * Get monthly evolution.
     */
    private function getMonthlyEvolution($professionalId, $startDate, $endDate)
    {
        return Event::where('professional_id', $professionalId)
            ->whereBetween('event_date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE_FORMAT(event_date, "%Y-%m") as month'),
                DB::raw('count(*) as events_count'),
                DB::raw('sum(final_value) as total_revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    /**
     * Get top customers.
     */
    private function getTopCustomers($professionalId, $startDate, $endDate)
    {
        return Event::where('professional_id', $professionalId)
            ->whereBetween('event_date', [$startDate, $endDate])
            ->with('customer')
            ->select('customer_id', DB::raw('count(*) as events_count'), DB::raw('sum(final_value) as total_spent'))
            ->groupBy('customer_id')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get most used equipment.
     */
    private function getMostUsedEquipment($professionalId, $startDate, $endDate)
    {
        return EventService::whereHas('event', function($query) use ($professionalId, $startDate, $endDate) {
                $query->where('professional_id', $professionalId)
                      ->whereBetween('event_date', [$startDate, $endDate]);
            })
            ->with('equipment')
            ->select('equipment_id', DB::raw('count(*) as usage_count'), DB::raw('sum(hours) as total_hours'))
            ->groupBy('equipment_id')
            ->orderBy('usage_count', 'desc')
            ->get();
    }

    /**
     * Get revenue by equipment.
     */
    private function getRevenueByEquipment($professionalId, $startDate, $endDate)
    {
        return EventService::whereHas('event', function($query) use ($professionalId, $startDate, $endDate) {
                $query->where('professional_id', $professionalId)
                      ->whereBetween('event_date', [$startDate, $endDate]);
            })
            ->with('equipment')
            ->select('equipment_id', DB::raw('sum(total_value) as total_revenue'))
            ->groupBy('equipment_id')
            ->orderBy('total_revenue', 'desc')
            ->get();
    }

    /**
     * Get hours by equipment.
     */
    private function getHoursByEquipment($professionalId, $startDate, $endDate)
    {
        return EventService::whereHas('event', function($query) use ($professionalId, $startDate, $endDate) {
                $query->where('professional_id', $professionalId)
                      ->whereBetween('event_date', [$startDate, $endDate]);
            })
            ->with('equipment')
            ->select('equipment_id', DB::raw('sum(hours) as total_hours'))
            ->groupBy('equipment_id')
            ->orderBy('total_hours', 'desc')
            ->get();
    }

    /**
     * Get events by type.
     */
    private function getEventsByType($professionalId, $startDate, $endDate)
    {
        return Event::where('professional_id', $professionalId)
            ->whereBetween('event_date', [$startDate, $endDate])
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->orderBy('count', 'desc')
            ->get();
    }

    /**
     * Get revenue by event type.
     */
    private function getRevenueByEventType($professionalId, $startDate, $endDate)
    {
        return Event::where('professional_id', $professionalId)
            ->whereBetween('event_date', [$startDate, $endDate])
            ->select('type', DB::raw('sum(final_value) as total_revenue'))
            ->groupBy('type')
            ->orderBy('total_revenue', 'desc')
            ->get();
    }

    /**
     * Get events by month.
     */
    private function getEventsByMonth($professionalId, $startDate, $endDate)
    {
        return Event::where('professional_id', $professionalId)
            ->whereBetween('event_date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE_FORMAT(event_date, "%Y-%m") as month'),
                'type',
                DB::raw('count(*) as count')
            )
            ->groupBy('month', 'type')
            ->orderBy('month')
            ->get();
    }

    /**
     * Get average by method.
     */
    private function getAverageByMethod($professionalId, $startDate, $endDate)
    {
        return EventPayment::whereHas('event', function($query) use ($professionalId, $startDate, $endDate) {
                $query->where('professional_id', $professionalId)
                      ->whereBetween('event_date', [$startDate, $endDate]);
            })
            ->where('status', 'confirmado')
            ->select('payment_method', DB::raw('avg(amount) as average_amount'))
            ->groupBy('payment_method')
            ->get();
    }

    /**
     * Get method evolution.
     */
    private function getMethodEvolution($professionalId, $startDate, $endDate)
    {
        return EventPayment::whereHas('event', function($query) use ($professionalId, $startDate, $endDate) {
                $query->where('professional_id', $professionalId)
                      ->whereBetween('event_date', [$startDate, $endDate]);
            })
            ->where('status', 'confirmado')
            ->select(
                DB::raw('DATE_FORMAT(payment_date, "%Y-%m") as month'),
                'payment_method',
                DB::raw('count(*) as count'),
                DB::raw('sum(amount) as total')
            )
            ->groupBy('month', 'payment_method')
            ->orderBy('month')
            ->get();
    }
}
