<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\BlockedDate;
use App\Models\Customer;
use App\Models\Professional;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function show($slug)
    {
        $professional = Professional::where('slug', $slug)->firstOrFail();
        $services = Service::where('professional_id', $professional->id)
            ->where('active', true)
            ->get();
        $gallery = $professional->galleries()->orderBy('order')->get();

        return view('public', compact('professional', 'services', 'gallery'));
    }

    public function getAvailableSlots(Request $request, $slug)
    {
        $professional = Professional::where('slug', $slug)->firstOrFail();
        
        $date = Carbon::parse($request->get('date'));
        $serviceId = $request->get('service_id');
        
        $service = Service::findOrFail($serviceId);
        $dayOfWeek = $date->dayOfWeek;

        // Verifica se a data está bloqueada
        $isBlocked = BlockedDate::where('professional_id', $professional->id)
            ->where('blocked_date', $date->format('Y-m-d'))
            ->exists();

        if ($isBlocked) {
            return response()->json(['slots' => []]);
        }

        // Busca disponibilidade para o dia da semana
        $availability = Availability::where('professional_id', $professional->id)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (!$availability) {
            return response()->json(['slots' => []]);
        }

        // Gera slots baseado na disponibilidade
        $slots = [];
        $currentTime = Carbon::parse($availability->start_time);
        $endTime = Carbon::parse($availability->end_time);

        while ($currentTime->lt($endTime)) {
            $slotStart = $currentTime->copy();
            $slotEnd = $currentTime->copy()->addMinutes($service->duration);

            if ($slotEnd->lte($endTime)) {
                // Verifica se o slot está disponível (não tem agendamento)
                $isAvailable = !Appointment::where('professional_id', $professional->id)
                    ->where('start_time', $date->copy()->setTimeFrom($slotStart))
                    ->exists();

                if ($isAvailable) {
                    $slots[] = [
                        'time' => $slotStart->format('H:i'),
                        'datetime' => $date->copy()->setTimeFrom($slotStart)->toIso8601String(),
                    ];
                }
            }

            $currentTime->addMinutes($availability->slot_duration);
        }

        return response()->json(['slots' => $slots]);
    }

    public function book(Request $request, $slug)
    {
        $professional = Professional::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        // Busca ou cria o cliente
        $customer = Customer::firstOrCreate(
            [
                'professional_id' => $professional->id,
                'phone' => $validated['phone'],
            ],
            [
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
            ]
        );

        // Cria o agendamento
        $service = Service::findOrFail($validated['service_id']);
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $appointment = Appointment::create([
            'professional_id' => $professional->id,
            'service_id' => $validated['service_id'],
            'customer_id' => $customer->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Agendamento realizado com sucesso!',
            'appointment' => $appointment,
        ]);
    }
}
