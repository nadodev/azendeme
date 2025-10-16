<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\BlockedDate;
use App\Models\Customer;
use App\Models\Gallery;
use App\Models\Professional;
use App\Models\Employee;
use App\Models\Service;
use App\Helpers\TemplateColors;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Support\Tenancy;

class PublicController extends Controller
{
   

    public function show(Request $request, $slug)
    {
        $professional = Professional::withoutGlobalScopes()->where('slug', $slug)->with('user')->firstOrFail();
        
        // Define o tenant como este professional para todas as queries seguintes
        // Isso faz com que o trait BelongsToTenant filtre automaticamente por professional_id
        Tenancy::setTenantId($professional->id);
        
        $user = $professional->user;

        // Carregar serviços ativos com seus funcionários (via pivot employee_service)
        // NÃO precisa filtrar por professional_id - o tenancy faz isso automaticamente
        $services = Service::with(['employees' => function ($q) {
                $q->where('active', true)
                  ->where('show_in_booking', true);
            }])
            ->where('active', true)
            ->orderBy('name')
            ->get();

        // Buscar employees ativos vinculados a serviços
        // NÃO precisa filtrar por professional_id - o tenancy faz isso automaticamente
        $employees = Employee::where('active', true)
            ->where('show_in_booking', true)
            ->whereHas('services', function ($q) {
                $q->where('active', true);
            })
            ->orderBy('name')
            ->get();

        // Gallery - tenancy filtra automaticamente
        $gallery = Gallery::with('album')
            ->orderBy('album_id')
            ->orderBy('order')
            ->get();
        
        // Removido: seleção de outros profissionais não se aplica na página pública
        $professionals = collect();

        
        // Buscar feedbacks públicos - tenancy filtra automaticamente
        try {
            $feedbacks = \App\Models\Feedback::where('visible_public', true)
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
        // Permite preview de templates via parâmetro ?preview_template=nome
        $previewTemplate = $request->query('preview_template');
        $allowedTemplates = ['clinic', 'clinic-modern', 'salon', 'salon-luxury', 'tattoo', 'tattoo-dark', 'barber', 'barber-vintage', 'spa', 'gym'];
        
        $isPreview = false;
        if ($previewTemplate && in_array($previewTemplate, $allowedTemplates)) {
            $template = $previewTemplate;
            $isPreview = true;
        } else {
            $template = $professional->template ?? 'clinic';
        }
        
        $templateView = "public.templates.{$template}";
        
        // Fallback to clinic if template doesn't exist
        if (!view()->exists($templateView)) {
            $templateView = 'public.templates.clinic';
        }

        // Verificar limites do plano
        $isPlan = $user->isFree();
        $planLimits = $user->planLimits();

        // Appointments - tenancy filtra automaticamente
        $appointments = Appointment::all();

        $appointmentsCount = $appointments->count();
        $appointmentsLimit = $planLimits['appointments_per_month'];

        $isPlanOver = $appointmentsCount >= $appointmentsLimit;

        return view($templateView, compact('professional', 'services', 'employees', 'gallery', 'settings', 'feedbacks', 'professionals', 'isPlan', 'planLimits', 'appointmentsCount', 'appointmentsLimit', 'isPlanOver', 'isPreview', 'template'));
    }

    public function getMonthAvailability(Request $request, $slug)
    {
        $professional = Professional::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();
        Tenancy::setTenantId($professional->id);

        
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        
        // Pega todos os dias da semana que o profissional trabalha - tenancy filtra automaticamente
        $availabilities = Availability::all();

        $workingDays = $availabilities->pluck('day_of_week')->toArray();
        
        // Pega datas bloqueadas - tenancy filtra automaticamente
        $blockedDates = BlockedDate::whereMonth('blocked_date', $month)
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
        $professional = Professional::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();
        
        Tenancy::setTenantId($professional->id);

        $date = Carbon::parse($request->get('date'));
        $serviceId = $request->get('service_id');
        $serviceIds = $request->get('service_ids', []);
        $employeeId = $request->get('employee_id');
        $isProfessional = $request->get('is_professional') === 'true';
        
        // Converte service_ids para array se for string ou usa service_id
        if (!is_array($serviceIds)) {
            if ($serviceIds) {
                // Se service_ids é uma string (ex: "1"), converte para array
                $serviceIds = [$serviceIds];
            } elseif ($serviceId) {
                // Se não tem service_ids mas tem service_id, usa ele
                $serviceIds = [$serviceId];
            } else {
                $serviceIds = [];
            }
        }
        
        // RF09: Calcula duração total
        if (!empty($serviceIds)) {
            $servicesSel = Service::whereIn('id', $serviceIds)->get();
            $duration = (int) $servicesSel->sum('duration');
        } else {
            $service = Service::findOrFail($serviceId);
            $requestedDuration = (int) $request->get('duration');
            $duration = $requestedDuration > 0 ? $requestedDuration : (int) $service->duration;
        }
        $dayOfWeek = $date->dayOfWeek;

        // Verifica se a data está bloqueada
        $isBlocked = BlockedDate::where('blocked_date', $date->format('Y-m-d'))->exists();
        if ($isBlocked) {
            return response()->json([]);
        }

        // RF09: Busca disponibilidade
        $availability = null;
        
        if ($employeeId && !$isProfessional) {
            // Disponibilidade específica do funcionário ou geral
            $availability = Availability::where('day_of_week', $dayOfWeek)
                ->where(function($q) use ($employeeId) {
                    $q->where('employee_id', $employeeId)
                      ->orWhereNull('employee_id');
                })
                ->orderByRaw('employee_id IS NOT NULL DESC')
                ->first();
        } else {
            // Disponibilidade geral do profissional
            $availability = Availability::where('day_of_week', $dayOfWeek)
                ->whereNull('employee_id')
                ->first();
        }
            
        if (!$availability) {
            return response()->json([]);
        }

        // RF09: Gera slots disponíveis
        $slots = [];
        $currentTime = Carbon::parse($availability->start_time);
        $endTime = Carbon::parse($availability->end_time);

        while ($currentTime->lt($endTime)) {
            $slotStart = $currentTime->copy();
            $slotEnd = $currentTime->copy()->addMinutes($duration);

            if ($slotEnd->lte($endTime)) {
                $slotDateTime = Carbon::parse($date->format('Y-m-d') . ' ' . $slotStart->format('H:i:s'));
                $slotEndDateTime = $slotDateTime->copy()->addMinutes($duration);
                
                // RNF09: Verifica conflito de agendamento
                $conflictQuery = Appointment::where('start_time', '<', $slotEndDateTime)
                    ->where('end_time', '>', $slotDateTime);
                    
                if ($employeeId && !$isProfessional) {
                    // Verifica conflito para funcionário específico ou sem funcionário
                    $conflictQuery->where(function($q) use ($employeeId) {
                        $q->where('employee_id', $employeeId)
                          ->orWhereNull('employee_id');
                    });
                } else {
                    // Verifica conflito para profissional (agendamentos sem funcionário)
                    $conflictQuery->whereNull('employee_id');
                }
                
                $hasConflict = $conflictQuery->exists();

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
        $professional = Professional::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();
        Tenancy::setTenantId($professional->id);

        // RF11: Regras de validação
        $rules = [
            'service_id' => 'nullable|exists:services,id',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'exists:services,id',
            'date' => 'required|date',
            'time' => 'required|string',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'employee_id' => 'nullable|exists:employees,id',
            'is_professional' => 'nullable|boolean',
        ];
        if (config('services.turnstile.enabled')) {
            $rules['cf-turnstile-response'] = 'required|string';
        }
        $validated = $request->validate($rules);
        // Turnstile verify if enabled
        if (config('services.turnstile.enabled')) {
            try {
                $client = new \GuzzleHttp\Client(['timeout' => 5]);
                $resp = $client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'form_params' => [
                        'secret' => config('services.turnstile.secret_key'),
                        'response' => $request->input('cf-turnstile-response'),
                        'remoteip' => $request->ip(),
                    ]
                ]);
                $body = json_decode((string) $resp->getBody(), true);
                if (!($body['success'] ?? false)) {
                    return response()->json(['success' => false, 'message' => 'Falha na verificação. Tente novamente.'], 422);
                }
            } catch (\Throwable $e) {
                \Log::warning('Turnstile verify error (booking)', ['error' => $e->getMessage()]);
                return response()->json(['success' => false, 'message' => 'Falha na verificação. Tente novamente.'], 422);
            }
        }

      
        // Busca ou cria o cliente - tenancy adiciona professional_id automaticamente
        $customer = Customer::firstOrCreate(
            [
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
        $baseStart = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        $baseEnd = $baseStart->copy()->addMinutes($totalDuration);

        // Impede conflito: se já existir agendamento que comece antes do fim e termine após o início
        // Tenancy filtra automaticamente por professional_id
        $hasConflict = Appointment::where('start_time', '<', $baseEnd)
            ->where('end_time', '>', $baseStart)
            ->exists();
        if ($hasConflict) {
            return response()->json([
                'success' => false,
                'message' => 'Este horário já foi reservado. Escolha outro horário.'
            ], 409);
        }

        $startTime = $baseStart;
        $endTime = $baseEnd;

        // RF11: Determina se é profissional ou funcionário
        $isProfessional = $validated['is_professional'] ?? false;
        $employeeId = null;
        
        if (!$isProfessional && isset($validated['employee_id'])) {
            $employeeId = $validated['employee_id'];
        }
        
        $appointment = Appointment::create([
            'professional_id' => $professional->id,
            'service_id' => $serviceIds[0], // Serviço principal
            'employee_id' => $employeeId,
            'customer_id' => $customer->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
            'has_multiple_services' => $hasMultiple,
            'total_price' => $totalPrice,
            'total_duration' => $totalDuration,
            'notes' => 'Agendado via página pública — Atendimento: ' . ($isProfessional ? $professional->name : ($employeeId ? 'Funcionário ID: ' . $employeeId : 'Não especificado')),
        ]);

      
        // Se tem múltiplos serviços, cria os registros na tabela pivot
        if ($hasMultiple) {
            foreach ($services as $service) {
                \App\Models\AppointmentService::create([
                    'appointment_id' => $appointment->id,
                    'service_id' => $service->id,
                    'price' => $service->price,
                    'duration' => $service->duration,
                    'assigned_employer_id' => $service->assigned_employer_id ?? null,
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
        
        $professional = Professional::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();
        Tenancy::setTenantId($professional->id);
        
        $promotion = \App\Models\Promotion::where('promo_code', $code)
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
            $discountText = 'R$ ' . number_format((float) $promotion->discount_fixed, 2, ',', '.') . ' OFF';
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
        $professional = Professional::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();
        Tenancy::setTenantId($professional->id);
        
        // Busca cliente por telefone ou email (tenancy filtra automaticamente)
        $customer = Customer::where(function($q) use ($request) {
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
        
        // Busca pontos de fidelidade (tenancy filtra automaticamente)
        $loyaltyPoints = \App\Models\LoyaltyPoint::where('customer_id', $customer->id)
            ->first();
        
        if (!$loyaltyPoints || $loyaltyPoints->points <= 0) {
            return response()->json([
                'found' => false,
                'message' => 'Você ainda não possui pontos.'
            ]);
        }
        
        // Busca recompensas ativas (tenancy filtra automaticamente)
        $rewards = \App\Models\LoyaltyReward::where('active', true)
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
