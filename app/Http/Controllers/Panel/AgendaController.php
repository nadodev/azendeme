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
        $date = $request->get('date');

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

        // Por padrão, mostra agendamentos futuros e de hoje
        if (!$date && !$status) {
            $query->where('start_time', '>=', now()->startOfDay());
        }

        $appointments = $query->orderBy('start_time')->get();
        $services = Service::where('professional_id', $professionalId)->get();

        // Preparar eventos para o calendário
        $calendarEvents = $appointments->map(function($appointment) {
            $statusColors = [
                'pending' => ['bg' => '#eab308', 'border' => '#ca8a04'],
                'confirmed' => ['bg' => '#3b82f6', 'border' => '#2563eb'],
                'cancelled' => ['bg' => '#ef4444', 'border' => '#dc2626'],
                'completed' => ['bg' => '#10b981', 'border' => '#059669'],
            ];
            $colors = $statusColors[$appointment->status] ?? ['bg' => '#6b7280', 'border' => '#4b5563'];
            
            return [
                'id' => $appointment->id,
                'title' => $appointment->customer->name . ' - ' . $appointment->service->name,
                'start' => $appointment->start_time,
                'end' => $appointment->end_time,
                'backgroundColor' => $colors['bg'],
                'borderColor' => $colors['border'],
                'extendedProps' => [
                    'customer' => $appointment->customer->name,
                    'phone' => $appointment->customer->phone,
                    'service' => $appointment->service->name,
                    'status' => $appointment->status,
                    'appointmentId' => $appointment->id
                ]
            ];
        });

        return view('panel.agenda', compact('appointments', 'services', 'date', 'calendarEvents'));
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

    public function edit(Appointment $agenda)
    {
        $professionalId = 1;
        $services = Service::where('professional_id', $professionalId)->where('active', true)->get();
        $customers = Customer::where('professional_id', $professionalId)->orderBy('name')->get();

        return view('panel.agenda-edit', ['appointment' => $agenda, 'services' => $services, 'customers' => $customers]);
    }

    public function update(Request $request, Appointment $agenda)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $startTime = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $agenda->update([
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

    public function destroy(Appointment $agenda)
    {
        $agenda->delete();
        return redirect()->route('panel.agenda.index')
            ->with('success', 'Agendamento excluído com sucesso!');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        $oldStatus = $appointment->status;
        $appointment->update(['status' => $validated['status']]);

        // Enviar e-mail para o cliente
        if ($appointment->customer->email) {
            try {
                if ($validated['status'] === 'confirmed') {
                    \Mail::to($appointment->customer->email)->send(
                        new \App\Mail\AppointmentConfirmed($appointment)
                    );
                } else {
                    \Mail::to($appointment->customer->email)->send(
                        new \App\Mail\AppointmentCancelled($appointment)
                    );
                }
            } catch (\Exception $e) {
                \Log::error('Erro ao enviar e-mail: ' . $e->getMessage());
            }
        }

        $message = $validated['status'] === 'confirmed' 
            ? 'Agendamento confirmado com sucesso!' 
            : 'Agendamento cancelado com sucesso!';

        return redirect()->route('panel.agenda.index')
            ->with('success', $message);
    }
}
