@php
    $user = auth()->user();
    if (!$user) { return; }
    $limits = $user->planLimits();

    // Resolve professional id (multi-tenant)
    $professionalId = optional($user->professional)->id ?? $user->id;

    // Current usage
    $servicesCount = \App\Models\Service::where('professional_id', $professionalId)->count();
    $customersCount = \App\Models\Customer::where('professional_id', $professionalId)->count();
    $monthStart = now()->startOfMonth();
    $appointmentsMonth = \App\Models\Appointment::where('professional_id', $professionalId)
        ->where('start_time', '>=', $monthStart)
        ->count();

    // Limits (fallback to large number if not defined)
    $limitServices = (int)($limits['services'] ?? 999999);
    $limitCustomers = (int)($limits['customers'] ?? 999999);
    $limitAppointments = (int)($limits['appointments_per_month'] ?? 999999);

    // Determine status
    $alerts = [];
    $near = function($count, $limit) { return $limit > 0 && $count >= max(1, floor($limit * 0.9)) && $count < $limit; };
    $hit  = function($count, $limit) { return $limit > 0 && $count >= $limit; };

    if ($limitServices < 999999) {
        if ($hit($servicesCount, $limitServices)) $alerts[] = ['label' => 'Serviços', 'count' => $servicesCount, 'limit' => $limitServices, 'type' => 'hit'];
        elseif ($near($servicesCount, $limitServices)) $alerts[] = ['label' => 'Serviços', 'count' => $servicesCount, 'limit' => $limitServices, 'type' => 'near'];
    }
    if ($limitCustomers < 999999) {
        if ($hit($customersCount, $limitCustomers)) $alerts[] = ['label' => 'Clientes', 'count' => $customersCount, 'limit' => $limitCustomers, 'type' => 'hit'];
        elseif ($near($customersCount, $limitCustomers)) $alerts[] = ['label' => 'Clientes', 'count' => $customersCount, 'limit' => $limitCustomers, 'type' => 'near'];
    }
    if ($limitAppointments < 999999) {
        if ($hit($appointmentsMonth, $limitAppointments)) $alerts[] = ['label' => 'Agendamentos/mês', 'count' => $appointmentsMonth, 'limit' => $limitAppointments, 'type' => 'hit'];
        elseif ($near($appointmentsMonth, $limitAppointments)) $alerts[] = ['label' => 'Agendamentos/mês', 'count' => $appointmentsMonth, 'limit' => $limitAppointments, 'type' => 'near'];
    }
@endphp

@if(!empty($alerts))
<div class="mb-6 rounded-xl border-2 border-amber-200 bg-amber-50 p-4">
    <div class="flex items-start gap-3">
        <div class="shrink-0 w-9 h-9 rounded-full bg-amber-500 text-white flex items-center justify-center">⚠️</div>
        <div class="flex-1">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                <h3 class="text-amber-900 font-bold">Você está próximo dos limites do seu plano</h3>
                <a href="{{ url('/panel/planos') }}" class="px-3 py-1.5 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-lg text-sm font-semibold hover:shadow">Ver Planos</a>
            </div>
            <p class="text-sm text-amber-800/90 mb-3">Para continuar crescendo sem limites, considere fazer upgrade.</p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-2">
                @foreach($alerts as $a)
                    <div class="p-2 rounded-lg border @if($a['type']==='hit') border-red-200 bg-red-50 @else border-amber-200 bg-white @endif">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-800">{{ $a['label'] }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full @if($a['type']==='hit') bg-red-600 text-white @else bg-amber-500 text-white @endif">
                                {{ $a['count'] }} / {{ $a['limit'] }}
                            </span>
                        </div>
                        @if($a['type']==='hit')
                            <p class="text-xs text-red-700 mt-1">Limite atingido</p>
                        @else
                            <p class="text-xs text-amber-700 mt-1">Quase lá…</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
 </div>
@endif


