<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCommercialProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventCommercialProposalController extends Controller
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

        $proposals = EventCommercialProposal::whereHas('event', function($query) use ($professional) {
                $query->where('professional_id', $professional->id);
            })
            ->with(['event.customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('panel.events.commercial-proposals.index', compact('proposals'));
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

        return view('panel.events.commercial-proposals.create', compact('event'));
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
            'proposal_date' => 'required|date',
            'valid_until' => 'required|date|after:proposal_date',
            'executive_summary' => 'required|string',
            'event_description' => 'required|string',
            'services_offered' => 'required|string',
            'equipment_included' => 'required|string',
            'team_structure' => 'required|string',
            'timeline' => 'required|string',
            'deliverables' => 'required|string',
            'terms_and_conditions' => 'required|string',
            'payment_schedule' => 'required|string',
            'total_value' => 'required|numeric|min:0.01',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_value' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Gerar número da proposta
        $proposalNumber = 'PROP-' . date('Y') . '-' . str_pad(EventCommercialProposal::count() + 1, 6, '0', STR_PAD_LEFT);

        // Calcular valor final
        $totalValue = $request->total_value;
        $discountValue = $request->discount_value ?? 0;
        $finalValue = $totalValue - $discountValue;

        $proposal = EventCommercialProposal::create([
            'event_id' => $event->id,
            'proposal_number' => $proposalNumber,
            'proposal_date' => $request->proposal_date,
            'valid_until' => $request->valid_until,
            'executive_summary' => $request->executive_summary,
            'event_description' => $request->event_description,
            'services_offered' => $request->services_offered,
            'equipment_included' => $request->equipment_included,
            'team_structure' => $request->team_structure,
            'timeline' => $request->timeline,
            'deliverables' => $request->deliverables,
            'terms_and_conditions' => $request->terms_and_conditions,
            'payment_schedule' => $request->payment_schedule,
            'total_value' => $totalValue,
            'discount_percentage' => $request->discount_percentage ?? 0,
            'discount_value' => $discountValue,
            'final_value' => $finalValue,
            'status' => 'rascunho',
            'notes' => $request->notes,
        ]);

        return redirect()->route('panel.events.commercial-proposals.show', $proposal)
            ->with('success', 'Proposta comercial criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventCommercialProposal $commercialProposal)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($commercialProposal->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $commercialProposal->load(['event.customer']);

        return view('panel.events.commercial-proposals.show', compact('commercialProposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventCommercialProposal $commercialProposal)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($commercialProposal->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        return view('panel.events.commercial-proposals.edit', compact('commercialProposal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventCommercialProposal $commercialProposal)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($commercialProposal->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'proposal_date' => 'required|date',
            'valid_until' => 'required|date|after:proposal_date',
            'executive_summary' => 'required|string',
            'event_description' => 'required|string',
            'services_offered' => 'required|string',
            'equipment_included' => 'required|string',
            'team_structure' => 'required|string',
            'timeline' => 'required|string',
            'deliverables' => 'required|string',
            'terms_and_conditions' => 'required|string',
            'payment_schedule' => 'required|string',
            'total_value' => 'required|numeric|min:0.01',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_value' => 'nullable|numeric|min:0',
            'status' => 'required|in:rascunho,enviada,em_analise,aprovada,rejeitada,expirada',
            'rejection_reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Calcular valor final
        $totalValue = $request->total_value;
        $discountValue = $request->discount_value ?? 0;
        $finalValue = $totalValue - $discountValue;

        $data = $request->all();
        $data['final_value'] = $finalValue;

        $commercialProposal->update($data);

        return redirect()->route('panel.events.commercial-proposals.show', $commercialProposal)
            ->with('success', 'Proposta comercial atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventCommercialProposal $commercialProposal)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($commercialProposal->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $commercialProposal->delete();

        return redirect()->route('panel.events.commercial-proposals.index')
            ->with('success', 'Proposta comercial excluída com sucesso!');
    }

    /**
     * Generate PDF for commercial proposal.
     */
    public function pdf(EventCommercialProposal $commercialProposal)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($commercialProposal->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $commercialProposal->load(['event.customer']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('panel.events.commercial-proposals.pdf', compact('commercialProposal'));

        return $pdf->download("proposta-comercial-{$commercialProposal->proposal_number}.pdf");
    }

    /**
     * Send proposal to client.
     */
    public function send(EventCommercialProposal $commercialProposal)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($commercialProposal->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $commercialProposal->update(['status' => 'enviada']);

        return back()->with('success', 'Proposta enviada para o cliente!');
    }

    /**
     * Approve proposal.
     */
    public function approve(EventCommercialProposal $commercialProposal)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($commercialProposal->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $commercialProposal->update(['status' => 'aprovada']);

        return back()->with('success', 'Proposta aprovada!');
    }

    /**
     * Reject proposal.
     */
    public function reject(Request $request, EventCommercialProposal $commercialProposal)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($commercialProposal->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $commercialProposal->update([
            'status' => 'rejeitada',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Proposta rejeitada!');
    }
}