<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $professionalId = 1;
        
        // Filtros
        $status = $request->get('status');
        $serviceId = $request->get('service_id');
        $date = $request->get('date', now()->format('Y-m-d'));

        $query = Appointment::where('professional_id', $professionalId)
            ->with(['customer', 'service']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        if ($date) {
            $query->whereDate('start_time', $date);
        }

        $appointments = $query->orderBy('start_time')->get();
        $services = Service::where('professional_id', $professionalId)->get();

        return view('panel.agenda', compact('appointments', 'services', 'date'));
    }

    public function create()
    {
        $professionalId = 1;
        $services = Service::where('professional_id', $professionalId)->where('active', true)->get();
        $customers = Customer::where('professional_id', $professionalId)->orderBy('name')->get();

        return view('panel.agenda-create', compact('services', 'customers'));
    }

    public function store(Request $request)
    {
        $professionalId = 1;

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $appointment = Appointment::create([
            'professional_id' => $professionalId,
            'customer_id' => $validated['customer_id'],
            'service_id' => $validated['service_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('panel.agenda.index')
            ->with('success', 'Agendamento criado com sucesso!');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['customer', 'service']);
        return view('panel.agenda-show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $professionalId = 1;
        $services = Service::where('professional_id', $professionalId)->where('active', true)->get();
        $customers = Customer::where('professional_id', $professionalId)->orderBy('name')->get();

        return view('panel.agenda-edit', compact('appointment', 'services', 'customers'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $appointment->update([
            'customer_id' => $validated['customer_id'],
            'service_id' => $validated['service_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('panel.agenda.index')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('panel.agenda.index')
            ->with('success', 'Agendamento excluído com sucesso!');
    }
}
