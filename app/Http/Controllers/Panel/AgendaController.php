<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\FinancialTransaction;
use App\Models\TransactionCategory;
use App\Models\CashRegister;
use App\Models\FeedbackRequest;
use App\Models\Payment;
use App\Services\LoyaltyService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        // Filtros
        $status = $request->get('status');
        $serviceId = $request->get('service_id');
        $date = $request->get('date');
        $employeeId = $request->get('employee_id');

        $query = Appointment::with(['customer', 'service', 'appointmentServices.service', 'professional', 'employee']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        if ($date) {
            $query->whereDate('start_time', $date);
        }

        // Por padrão, mostra agendamentos futuros e de hoje
        if (!$date && !$status) {
            $query->where('start_time', '>=', now()->startOfDay());
        }

        $appointments = $query->orderBy('start_time')->where('professional_id', auth()->user()->id)->get();
        $services = Service::where('active', true)->get();
        $employees = \App\Models\Employee::where('professional_id', auth()->user()->id)->where('active', true)->orderBy('name')->get();

        // Preparar eventos para o calendário
        $calendarEvents = $appointments->map(function($appointment) {
            $statusColors = [
                'pending' => ['bg' => '#eab308', 'border' => '#ca8a04'],
                'confirmed' => ['bg' => '#3b82f6', 'border' => '#2563eb'],
                'cancelled' => ['bg' => '#ef4444', 'border' => '#dc2626'],
                'completed' => ['bg' => '#10b981', 'border' => '#059669'],
            ];
            $colors = $statusColors[$appointment->status] ?? ['bg' => '#6b7280', 'border' => '#4b5563'];
            $customerName = optional($appointment->customer)->name ?? 'Cliente';
            $customerPhone = optional($appointment->customer)->phone ?? '';
            $serviceName = optional($appointment->service)->name ?? 'Serviço';
            $employeeName = optional($appointment->employee)->name ?? null;
            
            return [
                'id' => $appointment->id,
                'title' => $customerName . ' - ' . $serviceName,
                'start' => $appointment->start_time,
                'end' => $appointment->end_time,
                'backgroundColor' => $colors['bg'],
                'borderColor' => $colors['border'],
                'extendedProps' => [
                    'customer' => $customerName,
                    'phone' => $customerPhone,
                    'service' => $serviceName,
                    'status' => $appointment->status,
                    'employee' => $employeeName,
                    'appointmentId' => $appointment->id
                ]
            ];
        });

        return view('panel.agenda', compact('appointments', 'services', 'employees', 'date', 'calendarEvents'));
    }

    public function reschedule(Request $request, Appointment $appointment)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        if ($appointment->professional_id !== auth()->user()->id) {
            abort(403);
        }

        $newDate = Carbon::parse($request->input('date'));
        $start = Carbon::parse($appointment->start_time);
        $end = Carbon::parse($appointment->end_time);

        $newStart = $newDate->copy()->setTimeFromTimeString($start->format('H:i:s'));
        $newEnd = $newDate->copy()->setTimeFromTimeString($end->format('H:i:s'));

        $hasConflict = Appointment::where('professional_id', $appointment->professional_id)
            ->where('id', '!=', $appointment->id)
            ->where('start_time', '<', $newEnd)
            ->where('end_time', '>', $newStart)
            ->exists();
        if ($hasConflict) {
            return response()->json(['message' => 'Conflito de horário. Escolha outro dia.'], 409);
        }

        $appointment->start_time = $newStart;
        $appointment->end_time = $newEnd;
        $appointment->save();

        return response()->json(['success' => true]);
    }

    public function create()
    {
        // Enforce plan limit before showing form
        $limits = auth()->user()->planLimits();
        $monthlyLimit = (int) (($limits['appointments_per_month'] ?? 1));
        $professionalId = auth()->user()->id;
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        $currentCount = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$start, $end])
            ->count();
        if ($currentCount >= $monthlyLimit) {
            return redirect()->route('panel.agenda.index')
                ->withErrors(['plan' => 'Limite de agendamentos do plano atingido. Faça upgrade para criar mais.']);
        }

        $services = Service::where('active', true)->get();
        $customers = Customer::orderBy('name')->get();

        return view('panel.agenda-create', compact('services', 'customers'));
    }

    public function store(Request $request)
    {
        // Enforce plan limit before creating
        $limits = auth()->user()->planLimits();
        $monthlyLimit = (int) (($limits['appointments_per_month'] ?? 1));
        $professionalId = auth()->user()->id;
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        $currentCount = Appointment::where('professional_id', $professionalId)
            ->whereBetween('start_time', [$start, $end])
            ->count();
        if ($currentCount >= $monthlyLimit) {
            return redirect()->route('panel.agenda.index')
                ->withErrors(['plan' => 'Limite de agendamentos do plano atingido. Faça upgrade para criar mais.']);
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date',
            'notes' => 'nullable|string',
            'is_recurring' => 'nullable|boolean',
            'recurrence_type' => 'nullable|in:weekly,biweekly,monthly',
            'recurrence_interval' => 'nullable|integer|min:1|max:52',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        // Criar agendamento principal (professional_id preenchido via trait)
        $appointment = Appointment::create([
            'customer_id' => $validated['customer_id'],
            'service_id' => $validated['service_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
            'is_recurring' => $validated['is_recurring'] ?? false,
            'recurrence_type' => $validated['recurrence_type'] ?? null,
            'recurrence_interval' => $validated['recurrence_interval'] ?? null,
        ]);

        // Se for recorrente, criar os próximos agendamentos
        if (!empty($validated['is_recurring']) && !empty($validated['recurrence_interval'])) {
            $this->createRecurringAppointments($appointment, $validated);
        }

        $message = $appointment->is_recurring 
            ? 'Agendamento recorrente criado com sucesso!' 
            : 'Agendamento criado com sucesso!';

        return redirect()->route('panel.agenda.index')
            ->with('success', $message);
    }

    protected function createRecurringAppointments($parentAppointment, $data)
    {
        $interval = $data['recurrence_interval'];
        $type = $data['recurrence_type'];
        
        for ($i = 1; $i <= $interval; $i++) {
            $nextStartTime = clone $parentAppointment->start_time;
            
            switch ($type) {
                case 'weekly':
                    $nextStartTime->addWeeks($i);
                    break;
                case 'biweekly':
                    $nextStartTime->addWeeks($i * 2);
                    break;
                case 'monthly':
                    $nextStartTime->addMonths($i);
                    break;
            }
            
            $nextEndTime = clone $nextStartTime;
            $nextEndTime->addMinutes($parentAppointment->service->duration);
            
            Appointment::create([
                'customer_id' => $parentAppointment->customer_id,
                'service_id' => $parentAppointment->service_id,
                'start_time' => $nextStartTime,
                'end_time' => $nextEndTime,
                'status' => 'pending',
                'notes' => $parentAppointment->notes,
                'is_recurring' => true,
                'recurrence_type' => $type,
                'parent_appointment_id' => $parentAppointment->id,
            ]);
        }
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['customer', 'service']);
        return view('panel.agenda-show', compact('appointment'));
    }

    public function edit(Appointment $agenda)
    {
        $services = Service::where('active', true)->get();
        $customers = Customer::orderBy('name')->get();

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

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled,no-show',
        ]);

        $oldStatus = $appointment->status;
        $appointment->update(['status' => $validated['status']]);

        // Enviar e-mail para o cliente
        if ($appointment->customer && $appointment->customer->email) {
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
                \Log::error('Erro ao enviar e-mail de agendamento: ' . $e->getMessage());
                // Não falha o processo se o e-mail não for enviado
            }
        }

        $messages = [
            'confirmed' => 'Agendamento confirmado com sucesso!',
            'cancelled' => 'Agendamento cancelado com sucesso!',
            'no-show' => 'Agendamento marcado como "Não Compareceu"!',
        ];
        $message = $messages[$validated['status']] ?? 'Agendamento atualizado com sucesso!';

        return redirect()->route('panel.agenda.index')
            ->with('success', $message);
    }

    public function markAsCompleted(Request $request, Appointment $appointment)
    {
        \Log::info("markAsCompleted chamado. Request data:", $request->all());
        
        $validated = $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes' => 'nullable|string',
            'reward_id' => 'nullable|exists:loyalty_rewards,id',
        ]);

        // Atualizar status do agendamento
        $appointment->update([
            'status' => 'completed',
            'notes' => $validated['notes'] ?? $appointment->notes,
        ]);

        // Buscar categoria "Serviços Prestados"
        $serviceCategory = TransactionCategory::where('professional_id', $appointment->professional_id)
            ->where('type', 'income')
            ->where('name', 'Serviços Prestados')
            ->first();

        // Buscar ou criar caixa do dia
        $cashRegister = CashRegister::where('professional_id', $appointment->professional_id)
            ->where('date', today()->format('Y-m-d'))
            ->where('status', 'open')
            ->first();

        // Processar resgate de recompensa se selecionada
        $originalAmount = $appointment->service->price;
        $finalAmount = $originalAmount;
        $rewardMessage = "";
        $discountAmount = 0;
        $rewardName = null;
        $professionalId = $appointment->professional_id; // ID do profissional do agendamento
        
        if ($request->filled('reward_id')) {
            $reward = \App\Models\LoyaltyReward::find($request->reward_id);
            
            if ($reward) {
                $loyaltyPoints = \App\Models\LoyaltyPoint::where('professional_id', $professionalId)
                    ->where('customer_id', $appointment->customer_id)
                    ->first();
                
                // Verifica se o cliente tem pontos suficientes
                if ($loyaltyPoints && $loyaltyPoints->points >= $reward->points_required) {
                    // Calcula desconto
                    if ($reward->reward_type === 'percentage') {
                        $discountAmount = $finalAmount * ($reward->discount_value / 100);
                    } elseif ($reward->reward_type === 'fixed') {
                        $discountAmount = $reward->discount_value;
                    } elseif ($reward->reward_type === 'free_service') {
                        $discountAmount = $finalAmount;
                    }
                    
                    $finalAmount = max(0, $finalAmount - $discountAmount);
                    $rewardName = $reward->name;
                    
                    // Deduz pontos do cliente
                    \Log::info("Deduzindo {$reward->points_required} pontos do cliente {$appointment->customer_id}. Pontos antes: {$loyaltyPoints->points}");
                    
                    $loyaltyPoints->redeemPoints(
                        $reward->points_required, 
                        "Resgate de recompensa: {$reward->name} no agendamento #{$appointment->id}"
                    );
                    
                    \Log::info("Pontos após dedução: {$loyaltyPoints->points}");
                    
                    // Registra resgate na tabela de redemptions
                    \App\Models\LoyaltyRedemption::create([
                        'professional_id' => $professionalId,
                        'customer_id' => $appointment->customer_id,
                        'reward_id' => $reward->id,
                        'appointment_id' => $appointment->id,
                        'points_used' => $reward->points_required,
                        'status' => 'used',
                        'redemption_code' => 'RESGATE-' . strtoupper(uniqid()),
                        'used_at' => now(),
                    ]);
                    
                    $rewardMessage = " Recompensa '{$reward->name}' aplicada! Desconto: R$ " . number_format($discountAmount, 2, ',', '.') . " (-{$reward->points_required} pontos)";
                }
            }
        }

        // Montar descrição detalhada para a transação
        $description = 'Serviço: ' . $appointment->service->name . ' - Cliente: ' . (optional($appointment->customer)->name ?? 'Cliente');
        
        if ($discountAmount > 0) {
            $description .= "\n⭐ Desconto Fidelidade: {$rewardName}";
            $description .= "\n   Valor Original: R$ " . number_format($originalAmount, 2, ',', '.');
            $description .= "\n   Desconto: -R$ " . number_format($discountAmount, 2, ',', '.');
            $description .= "\n   Valor Final: R$ " . number_format($finalAmount, 2, ',', '.');
        }

        \Log::info("Criando transação financeira - Original: R$ {$originalAmount}, Desconto: R$ {$discountAmount}, Final: R$ {$finalAmount}");

        $dados = [
            'professional_id' => $appointment->professional_id,
            'cash_register_id' => $cashRegister ? $cashRegister->id : null,
            'type' => 'income',
            'category_id' => $serviceCategory ? $serviceCategory->id : null,
            'amount' => $finalAmount,
            'description' => $description,
            'payment_method_id' => $validated['payment_method_id'],
            'status' => 'completed',
            'appointment_id' => $appointment->id,
            'customer_id' => $appointment->customer_id,
            'service_id' => $appointment->service_id,
            'transaction_date' => today(),
            'paid_at' => now(),
            'created_by' => auth()->id(),   
        ];
        // Criar transação financeira com valor final (após desconto se houver)
        FinancialTransaction::create($dados);

        // Registrar na tabela payments
        Payment::create([
            'appointment_id' => $appointment->id,
            'payment_method_id' => $validated['payment_method_id'],
            'amount' => $finalAmount,
            'status' => 'completed',
            'paid_at' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        // Atualizar totais do caixa com valor final
        if ($cashRegister) {
            $cashRegister->total_income += $finalAmount;
            $cashRegister->closing_balance = $cashRegister->opening_balance + $cashRegister->total_income - $cashRegister->total_expense;
            $cashRegister->save();
        }

        // Processar pontos de fidelidade (ganho de novos pontos)
        try {
            $loyaltyService = app(LoyaltyService::class);
            $points = $loyaltyService->processAppointmentPoints($appointment);
            $loyaltyMessage = $points ? " Cliente ganhou {$points} pontos!" : "";
        } catch (\Exception $e) {
            $loyaltyMessage = "";
        }

        // Criar solicitação de feedback
        try {
            $feedbackRequest = FeedbackRequest::createFromAppointment($appointment);
            $feedbackUrl = $feedbackRequest->getPublicUrl();
            $feedbackMessage = " Link de feedback: {$feedbackUrl}";
        } catch (\Exception $e) {
            $feedbackMessage = "";
        }

        return redirect()->route('panel.agenda.index')
            ->with('success', 'Agendamento marcado como atendido e transação financeira criada!' . $rewardMessage . $loyaltyMessage . $feedbackMessage);
    }

    /**
     * Gera link de feedback para um agendamento
     */
    public function generateFeedbackLink($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Verificar se já existe um feedback request
        $existingRequest = FeedbackRequest::where('appointment_id', $appointment->id)->first();

        if ($existingRequest) {
            return redirect()->back()
                ->with('feedback_link', $existingRequest->getPublicUrl())
                ->with('success', 'Link de feedback já existente!');
        }

        // Criar novo feedback request
        $feedbackRequest = FeedbackRequest::createFromAppointment($appointment);

        return redirect()->back()
            ->with('feedback_link', $feedbackRequest->getPublicUrl())
            ->with('success', 'Link de feedback gerado com sucesso!');
    }

    public function getCustomerLoyalty($id)
    {
        try {
            $appointment = Appointment::with('customer')->findOrFail($id);
            
            if (!$appointment->customer) {
                return response()->json([
                    'has_points' => false,
                    'points' => 0,
                    'rewards' => [],
                    'message' => 'Cliente não encontrado'
                ]);
            }
            
            $customer = $appointment->customer;
            $professionalId = $appointment->professional_id;
            
            // Busca pontos do cliente
            $loyaltyPoints = \App\Models\LoyaltyPoint::where('professional_id', $professionalId)
                ->where('customer_id', $customer->id)
                ->first();
            
            $currentPoints = $loyaltyPoints ? $loyaltyPoints->points : 0;
            
            // Busca TODAS as recompensas ativas (independente dos pontos do cliente)
            $rewards = \App\Models\LoyaltyReward::where('professional_id', $professionalId)
                ->where('active', true)
                ->where(function($q) {
                    $q->whereNull('valid_until')
                      ->orWhere('valid_until', '>=', now());
                })
                ->orderBy('points_required', 'asc')
                ->get();
            
            return response()->json([
                'has_points' => $currentPoints > 0,
                'points' => $currentPoints,
                'rewards' => $rewards->map(function($reward) {
                    return [
                        'id' => $reward->id,
                        'name' => $reward->name,
                        'description' => $reward->description,
                        'points_required' => $reward->points_required,
                        'reward_type' => $reward->reward_type,
                        'discount_value' => $reward->discount_value,
                    ];
                })
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao buscar pontos do cliente: ' . $e->getMessage());
            return response()->json([
                'has_points' => false,
                'points' => 0,
                'rewards' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Appointment $agenda)
    {
        $agenda->delete();
        return redirect()->route('panel.agenda.index')
            ->with('success', 'Agendamento excluído com sucesso!');
    }
}
