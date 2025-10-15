<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventServiceOrder;
use App\Models\EventBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        $serviceOrders = EventServiceOrder::whereHas('event', function($query) use ($professional) {
                $query->where('professional_id', $professional->id);
            })
            ->with(['event.customer', 'budget'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('panel.events.service-orders.index', compact('serviceOrders'));
    }

    /**
     * Show event selection for creating service order.
     */
    public function selectEvent()
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        $events = Event::where('professional_id', $professional->id)
            ->with('customer')
            ->orderBy('event_date', 'desc')
            ->paginate(12);

        return view('panel.events.service-orders.select-event', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $budget = $event->latestBudget();
        
        return view('panel.events.service-orders.create', compact('event', 'budget'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_start_time' => 'required|date_format:H:i',
            'scheduled_end_time' => 'required|date_format:H:i',
            'description' => 'nullable|string',
            'equipment_list' => 'nullable|string',
            'employee_assignments' => 'nullable|string',
            'setup_instructions' => 'nullable|string',
            'special_requirements' => 'nullable|string',
            'total_value' => 'required|numeric|min:0',
        ]);

        // Validação customizada para horários que podem passar da meia-noite
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->scheduled_start_time);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $request->scheduled_end_time);
        
        if ($endTime->lessThan($startTime)) {
            $endTime->addDay();
        }
        
        $duration = $startTime->diffInHours($endTime);
        if ($duration > 24) {
            return back()->withErrors(['scheduled_end_time' => 'A duração da OS não pode ser superior a 24 horas.'])->withInput();
        }
        
        if ($duration < 1) {
            return back()->withErrors(['scheduled_end_time' => 'A duração da OS deve ser de pelo menos 1 hora.'])->withInput();
        }

        // Gerar número da OS
        $orderNumber = 'OS-' . date('Y') . '-' . str_pad(EventServiceOrder::count() + 1, 6, '0', STR_PAD_LEFT);

        $serviceOrder = EventServiceOrder::create([
            'event_id' => $event->id,
            'budget_id' => $event->latestBudget()?->id,
            'order_number' => $orderNumber,
            'order_date' => now()->toDateString(),
            'scheduled_date' => $request->scheduled_date,
            'scheduled_start_time' => $request->scheduled_start_time,
            'scheduled_end_time' => $request->scheduled_end_time,
            'description' => $request->description,
            'equipment_list' => $request->equipment_list,
            'employee_assignments' => $request->employee_assignments,
            'setup_instructions' => $request->setup_instructions,
            'special_requirements' => $request->special_requirements,
            'status' => 'rascunho',
            'total_value' => $request->total_value,
        ]);

        return redirect()->route('panel.events.service-orders.show', $serviceOrder)
            ->with('success', 'Ordem de Serviço criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventServiceOrder $serviceOrder)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceOrder->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $serviceOrder->load(['event.customer', 'budget', 'invoices']);

        return view('panel.events.service-orders.show', compact('serviceOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventServiceOrder $serviceOrder)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceOrder->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        return view('panel.events.service-orders.edit', compact('serviceOrder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventServiceOrder $serviceOrder)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceOrder->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'scheduled_date' => 'required|date',
            'scheduled_start_time' => 'required|date_format:H:i',
            'scheduled_end_time' => 'required|date_format:H:i',
            'description' => 'nullable|string',
            'equipment_list' => 'nullable|string',
            'employee_assignments' => 'nullable|string',
            'setup_instructions' => 'nullable|string',
            'special_requirements' => 'nullable|string',
            'status' => 'required|in:rascunho,agendada,em_execucao,concluida,cancelada',
            'completion_notes' => 'nullable|string',
            'issues_encountered' => 'nullable|string',
            'total_value' => 'required|numeric|min:0',
        ]);

        // Validação customizada para horários que podem passar da meia-noite
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->scheduled_start_time);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $request->scheduled_end_time);
        
        if ($endTime->lessThan($startTime)) {
            $endTime->addDay();
        }
        
        $duration = $startTime->diffInHours($endTime);
        if ($duration > 24) {
            return back()->withErrors(['scheduled_end_time' => 'A duração da OS não pode ser superior a 24 horas.'])->withInput();
        }
        
        if ($duration < 1) {
            return back()->withErrors(['scheduled_end_time' => 'A duração da OS deve ser de pelo menos 1 hora.'])->withInput();
        }

        $serviceOrder->update($request->all());

        return redirect()->route('panel.events.service-orders.show', $serviceOrder)
            ->with('success', 'Ordem de Serviço atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventServiceOrder $serviceOrder)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceOrder->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $serviceOrder->delete();

        return redirect()->route('panel.events.service-orders.index')
            ->with('success', 'Ordem de Serviço excluída com sucesso!');
    }

    /**
     * Create service order from approved budget.
     */
    public function createFromBudget(EventBudget $budget)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($budget->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        if ($budget->status !== 'aprovado') {
            return back()->with('error', 'Apenas orçamentos aprovados podem ser convertidos em Ordem de Serviço.');
        }

        // Verificar se já existe uma OS para este orçamento
        if ($budget->event->serviceOrders()->where('budget_id', $budget->id)->exists()) {
            return back()->with('error', 'Já existe uma Ordem de Serviço para este orçamento.');
        }

        // Gerar número da OS
        $orderNumber = 'OS-' . date('Y') . '-' . str_pad(EventServiceOrder::count() + 1, 6, '0', STR_PAD_LEFT);

        $serviceOrder = EventServiceOrder::create([
            'event_id' => $budget->event_id,
            'budget_id' => $budget->id,
            'order_number' => $orderNumber,
            'order_date' => now()->toDateString(),
            'scheduled_date' => $budget->event->event_date->toDateString(),
            'scheduled_start_time' => $budget->event->start_time->format('H:i'),
            'scheduled_end_time' => $budget->event->end_time->format('H:i'),
            'description' => 'Ordem de Serviço gerada automaticamente a partir do orçamento aprovado.',
            'equipment_list' => $budget->event->services->map(function($service) {
                return $service->equipment->name . ' - ' . $service->hours . 'h';
            })->join(', '),
            'employee_assignments' => $budget->event->employees->map(function($employee) {
                return $employee->name . ' (' . $employee->role . ') - ' . $employee->hours . 'h';
            })->join(', '),
            'setup_instructions' => $budget->event->setup_notes,
            'special_requirements' => $budget->event->equipment_notes,
            'status' => 'rascunho',
            'total_value' => $budget->total,
        ]);

        return redirect()->route('panel.events.service-orders.show', $serviceOrder)
            ->with('success', 'Ordem de Serviço criada com sucesso a partir do orçamento!');
    }

    /**
     * Generate PDF for the service order.
     */
    public function generatePdf(EventServiceOrder $serviceOrder)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceOrder->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $serviceOrder->load(['event.customer', 'budget']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('panel.events.service-orders.pdf', compact('serviceOrder'));

        return $pdf->download("ordem-servico-{$serviceOrder->order_number}.pdf");
    }

    /**
     * Start service order execution.
     */
    public function startExecution(EventServiceOrder $serviceOrder)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceOrder->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $serviceOrder->update(['status' => 'em_execucao']);

        return back()->with('success', 'Ordem de Serviço iniciada!');
    }

    /**
     * Complete service order.
     */
    public function complete(EventServiceOrder $serviceOrder)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceOrder->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $serviceOrder->update(['status' => 'concluida']);

        return back()->with('success', 'Ordem de Serviço concluída!');
    }

    /**
     * Cancel service order.
     */
    public function cancel(EventServiceOrder $serviceOrder)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceOrder->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $serviceOrder->update(['status' => 'cancelada']);

        return back()->with('success', 'Ordem de Serviço cancelada!');
    }
}