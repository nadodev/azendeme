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
        $professional = Professional::with('templateSetting')->where('slug', $slug)->firstOrFail();
        $services = Service::where('professional_id', $professional->id)
            ->where('active', true)
            ->get();
        $gallery = $professional->galleries()->orderBy('order')->get();

        // Carrega ou cria configurações do template
        if (!$professional->templateSetting) {
            $professional->templateSetting()->create([
                'primary_color' => $professional->brand_color ?? '#8B5CF6',
                'secondary_color' => '#A78BFA',
                'accent_color' => '#7C3AED',
                'background_color' => '#0F0F10',
                'text_color' => '#F5F5F5',
            ]);
            $professional->load('templateSetting');
        }
        
        $settings = $professional->templateSetting;

        // Determine which template to use
        $template = $professional->template ?? 'clinic';
        $templateView = "public.templates.{$template}";
        
        // Fallback to clinic if template doesn't exist
        if (!view()->exists($templateView)) {
            $templateView = 'public.templates.clinic';
        }

        return view($templateView, compact('professional', 'services', 'gallery', 'settings'));
    }

    public function getMonthAvailability(Request $request, $slug)
    {
        $professional = Professional::where('slug', $slug)->firstOrFail();
        
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        
        // Pega todos os dias da semana que o profissional trabalha
        $availabilities = Availability::where('professional_id', $professional->id)->get();
        $workingDays = $availabilities->pluck('day_of_week')->toArray();
        
        // Pega datas bloqueadas
        $blockedDates = BlockedDate::where('professional_id', $professional->id)
            ->whereMonth('blocked_date', $month)
            ->whereYear('blocked_date', $year)
            ->pluck('blocked_date')
            ->toArray();
        
        // Gera lista de dias disponíveis no mês
        $availableDays = [];
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day);
            $dayOfWeek = $date->dayOfWeek;
            
            // Verifica se é um dia de trabalho, não está bloqueado e não é passado
            $isWorkingDay = in_array($dayOfWeek, $workingDays);
            $isNotBlocked = !in_array($date->format('Y-m-d'), $blockedDates);
            $isNotPast = $date->isToday() || $date->isFuture();
            
            if ($isWorkingDay && $isNotBlocked && $isNotPast) {
                $availableDays[] = $date->format('Y-m-d');
            }
        }
        
        return response()->json([
            'available_days' => $availableDays,
            'blocked_dates' => $blockedDates,
        ]);
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
                // Cria o datetime completo para verificação
                $slotDateTime = Carbon::parse($date->format('Y-m-d') . ' ' . $slotStart->format('H:i:s'));
                $slotEndDateTime = $slotDateTime->copy()->addMinutes($service->duration);
                
                // Verifica se há conflito com algum agendamento existente
                // Um slot está ocupado se:
                // 1. Um agendamento começa antes do fim do slot E termina depois do início do slot
                $hasConflict = Appointment::where('professional_id', $professional->id)
                    ->where('start_time', '<', $slotEndDateTime)
                    ->where('end_time', '>', $slotDateTime)
                    ->exists();

                if (!$hasConflict) {
                    $slots[] = $slotStart->format('H:i');
                }
            }

            $currentTime->addMinutes($availability->slot_duration);
        }

        return response()->json($slots);
    }

    public function book(Request $request, $slug)
    {
        $professional = Professional::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'time' => 'required|string',
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
        $startTime = Carbon::parse($validated['date'] . ' ' . $validated['time']);
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
            'message' => 'Agendamento realizado com sucesso! Em breve você receberá uma confirmação.',
            'appointment' => $appointment,
        ]);
    }
}
