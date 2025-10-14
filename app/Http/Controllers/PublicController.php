<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\BlockedDate;
use App\Models\Customer;
use App\Models\Professional;
use App\Models\Service;
use App\Helpers\TemplateColors;
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
        
        // Buscar todos os profissionais disponíveis para seleção no agendamento
        $professionals = Professional::orderBy('is_main', 'desc')
            ->orderBy('name')
            ->get();
        
        // Buscar feedbacks públicos
        try {
            $feedbacks = \App\Models\Feedback::where('professional_id', $professional->id)
                ->where('visible_public', true)
                ->where('approved', true)
                ->with(['customer', 'service'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            $feedbacks = collect();
        }

        // Carrega ou cria configurações do template
        if (!$professional->templateSetting) {
            $template = $professional->template ?? 'clinic';
            $defaultColors = TemplateColors::getDefaults($template, $professional->brand_color);
            
            $professional->templateSetting()->create($defaultColors);
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

        return view($templateView, compact('professional', 'services', 'gallery', 'settings', 'feedbacks', 'professionals'));
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
            'service_id' => 'nullable|exists:services,id',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'exists:services,id',
            'date' => 'required|date',
            'time' => 'required|string',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'professional_id' => 'nullable|exists:professionals,id',
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

        // Determina se são múltiplos serviços
        $serviceIds = [];
        if (!empty($validated['service_ids'])) {
            $serviceIds = $validated['service_ids'];
            $hasMultiple = count($serviceIds) > 1;
        } else {
            $serviceIds = [$validated['service_id']];
            $hasMultiple = false;
        }

        // Calcula duração e preço total
        $services = Service::whereIn('id', $serviceIds)->get();
        $totalDuration = $services->sum('duration');
        $totalPrice = $services->sum('price');

        // Cria o agendamento
        $startTime = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        $endTime = $startTime->copy()->addMinutes($totalDuration);

        $appointment = Appointment::create([
            'professional_id' => $professional->id,
            'service_id' => $serviceIds[0], // Serviço principal
            'customer_id' => $customer->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
            'has_multiple_services' => $hasMultiple,
            'total_price' => $totalPrice,
            'total_duration' => $totalDuration,
        ]);

        // Se tem múltiplos serviços, cria os registros na tabela pivot
        if ($hasMultiple) {
            foreach ($services as $service) {
                \App\Models\AppointmentService::create([
                    'appointment_id' => $appointment->id,
                    'service_id' => $service->id,
                    'price' => $service->price,
                    'duration' => $service->duration,
                    'assigned_professional_id' => $service->assigned_professional_id,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Agendamento realizado com sucesso! Em breve você receberá uma confirmação.',
            'appointment' => $appointment,
        ]);
    }

    public function validatePromo(Request $request, $slug)
    {
        $code = strtoupper($request->input('code'));
        
        $professional = Professional::where('slug', $slug)->firstOrFail();
        
        $promotion = \App\Models\Promotion::where('promo_code', $code)
            ->where('professional_id', $professional->id)
            ->where('active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->first();
        
        if (!$promotion) {
            return response()->json([
                'valid' => false,
                'message' => 'Cupom inválido ou expirado.'
            ]);
        }
        
        // Verifica limite de usos
        if ($promotion->max_uses && $promotion->current_uses >= $promotion->max_uses) {
            return response()->json([
                'valid' => false,
                'message' => 'Este cupom atingiu o limite de usos.'
            ]);
        }
        
        // Monta mensagem de desconto
        $discountText = '';
        if ($promotion->discount_percentage) {
            $discountText = $promotion->discount_percentage . '% OFF';
        } elseif ($promotion->discount_fixed) {
            $discountText = 'R$ ' . number_format($promotion->discount_fixed, 2, ',', '.') . ' OFF';
        } elseif ($promotion->bonus_points) {
            $discountText = '+' . $promotion->bonus_points . ' pontos de bônus';
        } else {
            $discountText = 'Serviço Grátis';
        }
        
        return response()->json([
            'valid' => true,
            'discount' => $discountText,
            'promotion_id' => $promotion->id,
            'discount_percentage' => $promotion->discount_percentage,
            'discount_fixed' => $promotion->discount_fixed,
            'bonus_points' => $promotion->bonus_points,
        ]);
    }

    public function checkLoyalty(Request $request, $slug)
    {
        $professional = Professional::where('slug', $slug)->firstOrFail();
        
        // Busca cliente por telefone ou email
        $customer = Customer::where('professional_id', $professional->id)
            ->where(function($q) use ($request) {
                if ($request->input('phone')) {
                    $q->where('phone', $request->input('phone'));
                }
                if ($request->input('email')) {
                    $q->orWhere('email', $request->input('email'));
                }
            })
            ->first();
        
        if (!$customer) {
            return response()->json([
                'found' => false,
                'message' => 'Cliente não encontrado.'
            ]);
        }
        
        // Busca pontos de fidelidade
        $loyaltyPoints = \App\Models\LoyaltyPoint::where('professional_id', $professional->id)
            ->where('customer_id', $customer->id)
            ->first();
        
        if (!$loyaltyPoints || $loyaltyPoints->points <= 0) {
            return response()->json([
                'found' => false,
                'message' => 'Você ainda não possui pontos.'
            ]);
        }
        
        // Busca recompensas ativas
        $rewards = \App\Models\LoyaltyReward::where('professional_id', $professional->id)
            ->where('active', true)
            ->where(function($q) {
                $q->whereNull('valid_until')
                  ->orWhere('valid_until', '>=', now());
            })
            ->orderBy('points_required', 'asc')
            ->get();
        
        return response()->json([
            'found' => true,
            'customer_id' => $customer->id,
            'points' => $loyaltyPoints->points,
            'rewards' => $rewards->map(function($reward) {
                return [
                    'id' => $reward->id,
                    'name' => $reward->name,
                    'description' => $reward->description,
                    'points_required' => $reward->points_required,
                    'reward_type' => $reward->reward_type,
                    'discount_percentage' => $reward->reward_type === 'percentage' ? $reward->discount_value : null,
                    'discount_fixed' => $reward->reward_type === 'fixed' ? $reward->discount_value : null,
                ];
            })
        ]);
    }
}
