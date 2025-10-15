<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\EventEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventEquipmentController extends Controller
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
        
        $equipment = EventEquipment::where('professional_id', $professional->id)
            ->withCount('services')
            ->orderBy('name')
            ->paginate(15);

        return view('panel.events.equipment.index', compact('equipment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.events.equipment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $professional = Auth::user()->professional;

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'hourly_rate' => 'required|numeric|min:0',
            'minimum_hours' => 'required|integer|min:1',
            'setup_requirements' => 'nullable|string',
            'technical_specs' => 'nullable|string',
        ]);

        EventEquipment::create([
            'professional_id' => $professional->id,
            'name' => $request->name,
            'description' => $request->description,
            'hourly_rate' => $request->hourly_rate,
            'minimum_hours' => $request->minimum_hours,
            'setup_requirements' => $request->setup_requirements,
            'technical_specs' => $request->technical_specs,
            'is_active' => true,
        ]);

        return redirect()->route('panel.events.equipment.index')
            ->with('success', 'Equipamento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventEquipment $equipment)
    {
        $professional = Auth::user()->professional;
        if ($equipment->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $equipment->load('services.event.customer');
        
        return view('panel.events.equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventEquipment $equipment)
    {
        $professional = Auth::user()->professional;
        if ($equipment->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        return view('panel.events.equipment.edit', compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventEquipment $equipment)
    {
        $professional = Auth::user()->professional;
        if ($equipment->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'hourly_rate' => 'required|numeric|min:0',
            'minimum_hours' => 'required|integer|min:1',
            'setup_requirements' => 'nullable|string',
            'technical_specs' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $equipment->update($request->all());

        return redirect()->route('panel.events.equipment.index')
            ->with('success', 'Equipamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventEquipment $equipment)
    {
        $professional = Auth::user()->professional;
        if ($equipment->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        // Verificar se o equipamento está sendo usado em algum evento
        if ($equipment->services()->exists()) {
            return redirect()->route('panel.events.equipment.index')
                ->with('error', 'Não é possível remover equipamento que está sendo usado em eventos.');
        }

        $equipment->delete();

        return redirect()->route('panel.events.equipment.index')
            ->with('success', 'Equipamento removido com sucesso!');
    }

    /**
     * Toggle equipment active status
     */
    public function toggleStatus(EventEquipment $equipment)
    {
        $professional = Auth::user()->professional;
        if ($equipment->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $equipment->update(['is_active' => !$equipment->is_active]);

        $status = $equipment->is_active ? 'ativado' : 'desativado';
        
        return redirect()->route('panel.events.equipment.index')
            ->with('success', "Equipamento {$status} com sucesso!");
    }
}