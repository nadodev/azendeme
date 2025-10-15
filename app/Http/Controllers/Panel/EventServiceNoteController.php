<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventServiceNote;
use App\Models\EventServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventServiceNoteController extends Controller
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

        $serviceNotes = EventServiceNote::whereHas('event', function($query) use ($professional) {
                $query->where('professional_id', $professional->id);
            })
            ->with(['event.customer', 'serviceOrder'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('panel.events.service-notes.index', compact('serviceNotes'));
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

        $serviceOrders = $event->serviceOrders()->where('status', 'concluida')->get();

        return view('panel.events.service-notes.create', compact('event', 'serviceOrders'));
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
            'service_order_id' => 'nullable|exists:event_service_orders,id',
            'note_date' => 'required|date',
            'description' => 'required|string',
            'equipment_used' => 'required|string',
            'hours_worked' => 'required|string',
            'team_members' => 'required|string',
            'observations' => 'nullable|string',
            'issues_encountered' => 'nullable|string',
            'solutions_applied' => 'nullable|string',
            'client_feedback' => 'nullable|string',
            'total_hours' => 'required|numeric|min:0.01',
            'hourly_rate' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);

        // Gerar número da nota
        $noteNumber = 'NS-' . date('Y') . '-' . str_pad(EventServiceNote::count() + 1, 6, '0', STR_PAD_LEFT);

        $serviceNote = EventServiceNote::create([
            'event_id' => $event->id,
            'service_order_id' => $request->service_order_id,
            'note_number' => $noteNumber,
            'note_date' => $request->note_date,
            'description' => $request->description,
            'equipment_used' => $request->equipment_used,
            'hours_worked' => $request->hours_worked,
            'team_members' => $request->team_members,
            'observations' => $request->observations,
            'issues_encountered' => $request->issues_encountered,
            'solutions_applied' => $request->solutions_applied,
            'client_feedback' => $request->client_feedback,
            'total_hours' => $request->total_hours,
            'hourly_rate' => $request->hourly_rate,
            'total_value' => $request->total_hours * $request->hourly_rate,
            'status' => 'rascunho',
            'notes' => $request->notes,
        ]);

        return redirect()->route('panel.events.service-notes.show', $serviceNote)
            ->with('success', 'Nota de serviço criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventServiceNote $serviceNote)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceNote->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $serviceNote->load(['event.customer', 'serviceOrder']);

        return view('panel.events.service-notes.show', compact('serviceNote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventServiceNote $serviceNote)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceNote->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $serviceOrders = $serviceNote->event->serviceOrders()->where('status', 'concluida')->get();

        return view('panel.events.service-notes.edit', compact('serviceNote', 'serviceOrders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventServiceNote $serviceNote)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceNote->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'service_order_id' => 'nullable|exists:event_service_orders,id',
            'note_date' => 'required|date',
            'description' => 'required|string',
            'equipment_used' => 'required|string',
            'hours_worked' => 'required|string',
            'team_members' => 'required|string',
            'observations' => 'nullable|string',
            'issues_encountered' => 'nullable|string',
            'solutions_applied' => 'nullable|string',
            'client_feedback' => 'nullable|string',
            'total_hours' => 'required|numeric|min:0.01',
            'hourly_rate' => 'required|numeric|min:0.01',
            'status' => 'required|in:rascunho,enviada,aprovada,rejeitada',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['total_value'] = $request->total_hours * $request->hourly_rate;

        $serviceNote->update($data);

        return redirect()->route('panel.events.service-notes.show', $serviceNote)
            ->with('success', 'Nota de serviço atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventServiceNote $serviceNote)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceNote->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $serviceNote->delete();

        return redirect()->route('panel.events.service-notes.index')
            ->with('success', 'Nota de serviço excluída com sucesso!');
    }

    /**
     * Generate PDF for service note.
     */
    public function pdf(EventServiceNote $serviceNote)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceNote->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $serviceNote->load(['event.customer', 'serviceOrder']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('panel.events.service-notes.pdf', compact('serviceNote'));

        return $pdf->download("nota-servico-{$serviceNote->note_number}.pdf");
    }
}