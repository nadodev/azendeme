<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Customer;
use App\Models\EventEquipment;
use App\Models\EventService;
use App\Models\EventEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
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
        
        $events = Event::where('professional_id', $professional->id)
            ->with(['customer', 'services.equipment'])
            ->orderBy('event_date', 'desc')
            ->paginate(15);

        return view('panel.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }
        
        $customers = Customer::where('professional_id', $professional->id)->get();
        $equipment = EventEquipment::where('professional_id', $professional->id)->active()->get();

        return view('panel.events.create', compact('customers', 'equipment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $professional = Auth::user()->professional;

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:formatura,aniversario,casamento,carnaval,corporativo,outro',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'zip_code' => 'nullable|string|max:10',
            'status' => 'required|in:orcamento,confirmado,em_andamento,concluido,cancelado',
            'notes' => 'nullable|string',
            'equipment_notes' => 'nullable|string',
            'setup_notes' => 'nullable|string',
        ]);

        // Validação customizada para horários que podem passar da meia-noite
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);
        
        // Se o horário de término for menor que o de início, assumimos que é no dia seguinte
        if ($endTime->lessThan($startTime)) {
            $endTime->addDay();
        }
        
        // Verifica se a duração não é muito longa (máximo 24 horas)
        $duration = $startTime->diffInHours($endTime);
        if ($duration > 24) {
            return back()->withErrors(['end_time' => 'A duração do evento não pode ser superior a 24 horas.'])->withInput();
        }
        
        // Verifica se a duração é pelo menos 1 hora
        if ($duration < 1) {
            return back()->withErrors(['end_time' => 'A duração do evento deve ser de pelo menos 1 hora.'])->withInput();
        }

        $event = Event::create([
            'professional_id' => $professional->id,
            'customer_id' => $request->customer_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'event_date' => $request->event_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'status' => $request->status,
            'notes' => $request->notes,
            'equipment_notes' => $request->equipment_notes,
            'setup_notes' => $request->setup_notes,
        ]);

        return redirect()->route('panel.events.show', $event)
            ->with('success', 'Evento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $professional = Auth::user()->professional;
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $event->load(['customer', 'services.equipment', 'employees', 'budgets']);
        $equipment = EventEquipment::where('professional_id', $professional->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('panel.events.show', compact('event', 'equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $professional = Auth::user()->professional;
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $customers = Customer::where('professional_id', $professional->id)->get();
        $equipment = EventEquipment::where('professional_id', $professional->id)->active()->get();

        return view('panel.events.edit', compact('event', 'customers', 'equipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $professional = Auth::user()->professional;
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:formatura,aniversario,casamento,carnaval,corporativo,outro',
            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'zip_code' => 'nullable|string|max:10',
            'status' => 'required|in:orcamento,confirmado,em_andamento,concluido,cancelado',
            'notes' => 'nullable|string',
            'equipment_notes' => 'nullable|string',
            'setup_notes' => 'nullable|string',
        ]);

        // Validação customizada para horários que podem passar da meia-noite
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);
        
        // Se o horário de término for menor que o de início, assumimos que é no dia seguinte
        if ($endTime->lessThan($startTime)) {
            $endTime->addDay();
        }
        
        // Verifica se a duração não é muito longa (máximo 24 horas)
        $duration = $startTime->diffInHours($endTime);
        if ($duration > 24) {
            return back()->withErrors(['end_time' => 'A duração do evento não pode ser superior a 24 horas.'])->withInput();
        }
        
        // Verifica se a duração é pelo menos 1 hora
        if ($duration < 1) {
            return back()->withErrors(['end_time' => 'A duração do evento deve ser de pelo menos 1 hora.'])->withInput();
        }

        $event->update($request->all());

        return redirect()->route('panel.events.show', $event)
            ->with('success', 'Evento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $professional = Auth::user()->professional;
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $event->delete();

        return redirect()->route('panel.events.index')
            ->with('success', 'Evento removido com sucesso!');
    }

    /**
     * Add service to event
     */
    public function addService(Request $request, Event $event)
    {
        $professional = Auth::user()->professional;
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'equipment_id' => 'required|exists:event_equipment,id',
            'hours' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $equipment = EventEquipment::findOrFail($request->equipment_id);
        
        EventService::create([
            'event_id' => $event->id,
            'equipment_id' => $request->equipment_id,
            'hours' => $request->hours,
            'hourly_rate' => $equipment->hourly_rate,
            'notes' => $request->notes,
        ]);

        $this->updateEventTotals($event);

        return redirect()->route('panel.events.show', $event)
            ->with('success', 'Serviço adicionado com sucesso!');
    }

    /**
     * Remove service from event
     */
    public function removeService(EventService $service)
    {
        $professional = Auth::user()->professional;
        if ($service->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $event = $service->event;
        $service->delete();
        
        $this->updateEventTotals($event);

        return redirect()->route('panel.events.show', $event)
            ->with('success', 'Serviço removido com sucesso!');
    }

    /**
     * Add employee to event
     */
    public function addEmployee(Request $request, Event $event)
    {
        $professional = Auth::user()->professional;
        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'role' => 'required|string|max:255',
            'hourly_rate' => 'required|numeric|min:0',
            'hours' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        EventEmployee::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'role' => $request->role,
            'hourly_rate' => $request->hourly_rate,
            'hours' => $request->hours,
            'notes' => $request->notes,
        ]);

        $this->updateEventTotals($event);

        return redirect()->route('panel.events.show', $event)
            ->with('success', 'Funcionário adicionado com sucesso!');
    }

    /**
     * Remove employee from event
     */
    public function removeEmployee(EventEmployee $employee)
    {
        $professional = Auth::user()->professional;
        if ($employee->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }
        
        $event = $employee->event;
        $employee->delete();
        
        $this->updateEventTotals($event);

        return redirect()->route('panel.events.show', $event)
            ->with('success', 'Funcionário removido com sucesso!');
    }

    /**
     * Update event totals
     */
    private function updateEventTotals(Event $event)
    {
        $equipmentTotal = $event->services()->sum('total_value');
        $employeeTotal = $event->employees()->sum('total_value');
        $totalValue = $equipmentTotal + $employeeTotal;
        
        $event->update([
            'total_value' => $totalValue,
            'final_value' => $totalValue - $event->discount,
        ]);
    }
}