<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventContract;
use App\Models\EventBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventContractController extends Controller
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

        $contracts = EventContract::whereHas('event', function($query) use ($professional) {
                $query->where('professional_id', $professional->id);
            })
            ->with(['event.customer', 'budget'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('panel.events.contracts.index', compact('contracts'));
    }

    /**
     * Show the form for selecting an event to create a contract.
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
            ->paginate(15);

        return view('panel.events.contracts.select-event', compact('events'));
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

        $budgets = $event->budgets()->where('status', 'aprovado')->get();

        return view('panel.events.contracts.create', compact('event', 'budgets'));
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
            'budget_id' => 'nullable|exists:event_budgets,id',
            'contract_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'terms_and_conditions' => 'required|string',
            'payment_terms' => 'required|string',
            'cancellation_policy' => 'required|string',
            'liability_terms' => 'required|string',
            'total_value' => 'required|numeric|min:0.01',
            'advance_payment' => 'nullable|numeric|min:0',
            'final_payment' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Gerar número do contrato
        $contractNumber = 'CTR-' . date('Y') . '-' . str_pad(EventContract::count() + 1, 6, '0', STR_PAD_LEFT);

        $contract = EventContract::create([
            'event_id' => $event->id,
            'budget_id' => $request->budget_id,
            'contract_number' => $contractNumber,
            'contract_date' => $request->contract_date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'terms_and_conditions' => $request->terms_and_conditions,
            'payment_terms' => $request->payment_terms,
            'cancellation_policy' => $request->cancellation_policy,
            'liability_terms' => $request->liability_terms,
            'total_value' => $request->total_value,
            'advance_payment' => $request->advance_payment ?? 0,
            'final_payment' => $request->final_payment ?? 0,
            'status' => 'rascunho',
            'notes' => $request->notes,
        ]);

        return redirect()->route('panel.events.contracts.show', $contract)
            ->with('success', 'Contrato criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventContract $contract)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($contract->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $contract->load(['event.customer', 'budget']);

        return view('panel.events.contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventContract $contract)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($contract->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $budgets = $contract->event->budgets()->where('status', 'aprovado')->get();

        return view('panel.events.contracts.edit', compact('contract', 'budgets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventContract $contract)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($contract->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'budget_id' => 'nullable|exists:event_budgets,id',
            'contract_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'terms_and_conditions' => 'required|string',
            'payment_terms' => 'required|string',
            'cancellation_policy' => 'required|string',
            'liability_terms' => 'required|string',
            'total_value' => 'required|numeric|min:0.01',
            'advance_payment' => 'nullable|numeric|min:0',
            'final_payment' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:rascunho,enviado,assinado,ativo,concluido,cancelado',
            'notes' => 'nullable|string',
        ]);

        $contract->update($request->all());

        return redirect()->route('panel.events.contracts.show', $contract)
            ->with('success', 'Contrato atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventContract $contract)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($contract->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $contract->delete();

        return redirect()->route('panel.events.contracts.index')
            ->with('success', 'Contrato excluído com sucesso!');
    }

    /**
     * Generate PDF for contract.
     */
    public function pdf(EventContract $contract)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($contract->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $contract->load(['event.customer', 'budget']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('panel.events.contracts.pdf', compact('contract'));

        return $pdf->download("contrato-{$contract->contract_number}.pdf");
    }

    /**
     * Send contract to client.
     */
    public function send(EventContract $contract)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($contract->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $contract->update(['status' => 'enviado']);

        return back()->with('success', 'Contrato enviado para o cliente!');
    }

    /**
     * Mark contract as signed.
     */
    public function sign(EventContract $contract)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($contract->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $contract->update([
            'status' => 'assinado',
            'signed_date' => now()->toDateString(),
        ]);

        return back()->with('success', 'Contrato marcado como assinado!');
    }
}