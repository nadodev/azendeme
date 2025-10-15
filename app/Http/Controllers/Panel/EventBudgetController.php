<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class EventBudgetController extends Controller
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
        
        $budgets = EventBudget::whereHas('event', function($query) use ($professional) {
                $query->where('professional_id', $professional->id);
            })
            ->with(['event.customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('panel.events.budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        $professional = Auth::user()->professional;
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $event->load(['services.equipment', 'employees']);
        
        return view('panel.events.budgets.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $professional = Auth::user()->professional;
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'valid_until' => 'required|date|after:today',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
        ]);

        $budget = EventBudget::create([
            'event_id' => $event->id,
            'valid_until' => $request->valid_until,
            'discount_percentage' => $request->discount_percentage ?? 0,
            'notes' => $request->notes,
            'terms' => $request->terms,
            'status' => 'rascunho',
        ]);

        return redirect()->route('panel.events.budgets.show', $budget)
            ->with('success', 'Orçamento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventBudget $budget)
    {
        $professional = Auth::user()->professional;
        if ($budget->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $budget->load(['event.customer', 'event.services.equipment', 'event.employees']);
        
        return view('panel.events.budgets.show', compact('budget'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventBudget $budget)
    {
        $professional = Auth::user()->professional;
        if ($budget->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        return view('panel.events.budgets.edit', compact('budget'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventBudget $budget)
    {
        $professional = Auth::user()->professional;
        if ($budget->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'valid_until' => 'required|date',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
        ]);

        $budget->update($request->all());

        return redirect()->route('panel.events.budgets.show', $budget)
            ->with('success', 'Orçamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventBudget $budget)
    {
        $professional = Auth::user()->professional;
        if ($budget->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $budget->delete();

        return redirect()->route('panel.events.budgets.index')
            ->with('success', 'Orçamento removido com sucesso!');
    }

    /**
     * Generate PDF for budget
     */
    public function generatePdf(EventBudget $budget)
    {
        $professional = Auth::user()->professional;
        if ($budget->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $budget->load(['event.customer', 'event.services.equipment', 'event.employees']);
        
        $pdf = Pdf::loadView('panel.events.budgets.pdf', compact('budget'));
        
        return $pdf->download("orcamento-{$budget->budget_number}.pdf");
    }

    /**
     * Send budget to customer
     */
    public function sendToCustomer(EventBudget $budget)
    {
        $professional = Auth::user()->professional;
        if ($budget->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $budget->update(['status' => 'enviado']);

        // Aqui você pode implementar o envio por email
        // Mail::to($budget->event->customer->email)->send(new EventBudgetMail($budget));

        return redirect()->route('panel.events.budgets.show', $budget)
            ->with('success', 'Orçamento enviado para o cliente!');
    }

    /**
     * Approve budget
     */
    public function approve(EventBudget $budget)
    {
        $professional = Auth::user()->professional;
        if ($budget->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $budget->update(['status' => 'aprovado']);

        return redirect()->route('panel.events.budgets.show', $budget)
            ->with('success', 'Orçamento aprovado!');
    }

    /**
     * Reject budget
     */
    public function reject(EventBudget $budget)
    {
        $professional = Auth::user()->professional;
        if ($budget->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $budget->update(['status' => 'rejeitado']);

        return redirect()->route('panel.events.budgets.show', $budget)
            ->with('success', 'Orçamento rejeitado!');
    }

    /**
     * Create invoice from approved budget.
     */
    public function createInvoice(EventBudget $budget)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($budget->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        if ($budget->status !== 'aprovado') {
            return back()->with('error', 'Apenas orçamentos aprovados podem ser convertidos em fatura.');
        }

        // Verificar se já existe uma fatura para este orçamento
        if ($budget->event->invoices()->where('budget_id', $budget->id)->exists()) {
            return back()->with('error', 'Já existe uma fatura para este orçamento.');
        }

        // Gerar número da fatura
        $invoiceNumber = 'FAT-' . date('Y') . '-' . str_pad(\App\Models\EventInvoice::count() + 1, 6, '0', STR_PAD_LEFT);

        $invoice = \App\Models\EventInvoice::create([
            'event_id' => $budget->event_id,
            'budget_id' => $budget->id,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => now()->toDateString(),
            'due_date' => now()->addDays(30)->toDateString(),
            'subtotal' => $budget->subtotal,
            'discount_percentage' => $budget->discount_percentage,
            'discount_value' => $budget->discount_value,
            'tax_percentage' => 0, // Pode ser configurado
            'tax_value' => 0,
            'total' => $budget->total,
            'status' => 'rascunho',
            'notes' => 'Fatura gerada automaticamente a partir do orçamento aprovado.',
            'payment_terms' => 'Pagamento à vista ou conforme acordado.',
        ]);

        return redirect()->route('panel.events.invoices.show', $invoice)
            ->with('success', 'Fatura criada com sucesso a partir do orçamento!');
    }

    /**
     * Create service order from approved budget.
     */
    public function createServiceOrder(EventBudget $budget)
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
        $orderNumber = 'OS-' . date('Y') . '-' . str_pad(\App\Models\EventServiceOrder::count() + 1, 6, '0', STR_PAD_LEFT);

        $serviceOrder = \App\Models\EventServiceOrder::create([
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
}