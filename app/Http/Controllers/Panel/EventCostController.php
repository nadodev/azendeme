<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCost;
use App\Models\EventCostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventCostController extends Controller
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

        $costs = EventCost::whereHas('event', function($query) use ($professional) {
                $query->where('professional_id', $professional->id);
            })
            ->with(['event.customer', 'costCategory'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('panel.events.costs.index', compact('costs'));
    }

    /**
     * Show the form for selecting an event to create a cost.
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

        return view('panel.events.costs.select-event', compact('events'));
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

        $costCategories = EventCostCategory::where('professional_id', $professional->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        if ($costCategories->isEmpty()) {
            // Seed default categories for this professional if none exist
            $defaults = [
                ['name' => 'Equipamentos', 'description' => 'Custos relacionados a equipamentos de fotografia e eventos', 'color' => '#3B82F6', 'sort_order' => 1],
                ['name' => 'Transporte', 'description' => 'Custos de transporte e deslocamento', 'color' => '#10B981', 'sort_order' => 2],
                ['name' => 'Alimentação', 'description' => 'Custos com alimentação da equipe', 'color' => '#F59E0B', 'sort_order' => 3],
                ['name' => 'Hospedagem', 'description' => 'Custos de hospedagem quando necessário', 'color' => '#8B5CF6', 'sort_order' => 4],
                ['name' => 'Materiais', 'description' => 'Materiais diversos para eventos', 'color' => '#EF4444', 'sort_order' => 5],
                ['name' => 'Marketing', 'description' => 'Custos de marketing e divulgação', 'color' => '#EC4899', 'sort_order' => 6],
                ['name' => 'Manutenção', 'description' => 'Manutenção e reparos de equipamentos', 'color' => '#6B7280', 'sort_order' => 7],
                ['name' => 'Imprevistos', 'description' => 'Custos imprevistos e emergências', 'color' => '#F97316', 'sort_order' => 8],
            ];
            foreach ($defaults as $data) {
                EventCostCategory::create([
                    'professional_id' => $professional->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'color' => $data['color'],
                    'is_active' => true,
                    'sort_order' => $data['sort_order'],
                ]);
            }
            $costCategories = EventCostCategory::where('professional_id', $professional->id)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        }

        return view('panel.events.costs.create', compact('event', 'costCategories'));
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
            'cost_category_id' => 'required|exists:event_cost_categories,id',
            'cost_date' => 'required|date',
            'description' => 'required|string|max:255',
            'details' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'cost_type' => 'required|in:fixo,variavel,imprevisto',
            'payment_status' => 'required|in:pendente,pago,parcelado',
            'due_date' => 'nullable|date|after_or_equal:cost_date',
            'supplier' => 'nullable|string|max:255',
            'invoice_number' => 'nullable|string|max:255',
            'payment_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Gerar número do custo
        $costNumber = 'CST-' . date('Y') . '-' . str_pad(EventCost::count() + 1, 6, '0', STR_PAD_LEFT);

        $cost = EventCost::create([
            'event_id' => $event->id,
            'cost_category_id' => $request->cost_category_id,
            'cost_number' => $costNumber,
            'cost_date' => $request->cost_date,
            'description' => $request->description,
            'details' => $request->details,
            'amount' => $request->amount,
            'cost_type' => $request->cost_type,
            'payment_status' => $request->payment_status,
            'due_date' => $request->due_date,
            'supplier' => $request->supplier,
            'invoice_number' => $request->invoice_number,
            'payment_reference' => $request->payment_reference,
            'status' => 'rascunho',
            'notes' => $request->notes,
        ]);

        return redirect()->route('panel.events.costs.show', $cost)
            ->with('success', 'Custo registrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventCost $cost)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($cost->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $cost->load(['event.customer', 'costCategory']);

        return view('panel.events.costs.show', compact('cost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventCost $cost)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($cost->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $costCategories = EventCostCategory::where('professional_id', $professional->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        if ($costCategories->isEmpty()) {
            $defaults = [
                ['name' => 'Equipamentos', 'description' => 'Custos relacionados a equipamentos de fotografia e eventos', 'color' => '#3B82F6', 'sort_order' => 1],
                ['name' => 'Transporte', 'description' => 'Custos de transporte e deslocamento', 'color' => '#10B981', 'sort_order' => 2],
                ['name' => 'Alimentação', 'description' => 'Custos com alimentação da equipe', 'color' => '#F59E0B', 'sort_order' => 3],
                ['name' => 'Hospedagem', 'description' => 'Custos de hospedagem quando necessário', 'color' => '#8B5CF6', 'sort_order' => 4],
                ['name' => 'Materiais', 'description' => 'Materiais diversos para eventos', 'color' => '#EF4444', 'sort_order' => 5],
                ['name' => 'Marketing', 'description' => 'Custos de marketing e divulgação', 'color' => '#EC4899', 'sort_order' => 6],
                ['name' => 'Manutenção', 'description' => 'Manutenção e reparos de equipamentos', 'color' => '#6B7280', 'sort_order' => 7],
                ['name' => 'Imprevistos', 'description' => 'Custos imprevistos e emergências', 'color' => '#F97316', 'sort_order' => 8],
            ];
            foreach ($defaults as $data) {
                EventCostCategory::create([
                    'professional_id' => $professional->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'color' => $data['color'],
                    'is_active' => true,
                    'sort_order' => $data['sort_order'],
                ]);
            }
            $costCategories = EventCostCategory::where('professional_id', $professional->id)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        }

        return view('panel.events.costs.edit', compact('cost', 'costCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventCost $cost)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($cost->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'cost_category_id' => 'required|exists:event_cost_categories,id',
            'cost_date' => 'required|date',
            'description' => 'required|string|max:255',
            'details' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'cost_type' => 'required|in:fixo,variavel,imprevisto',
            'payment_status' => 'required|in:pendente,pago,parcelado',
            'due_date' => 'nullable|date|after_or_equal:cost_date',
            'supplier' => 'nullable|string|max:255',
            'invoice_number' => 'nullable|string|max:255',
            'payment_reference' => 'nullable|string|max:255',
            'status' => 'required|in:rascunho,confirmado,pago,cancelado',
            'notes' => 'nullable|string',
        ]);

        $cost->update($request->all());

        return redirect()->route('panel.events.costs.show', $cost)
            ->with('success', 'Custo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventCost $cost)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($cost->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $cost->delete();

        return redirect()->route('panel.events.costs.index')
            ->with('success', 'Custo excluído com sucesso!');
    }

    /**
     * Mark cost as paid.
     */
    public function markPaid(EventCost $cost)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($cost->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $cost->update([
            'payment_status' => 'pago',
            'status' => 'pago',
        ]);

        return back()->with('success', 'Custo marcado como pago!');
    }
}