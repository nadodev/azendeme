<!-- Visualização em Calendário -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <!-- Cabeçalho do Calendário -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <h2 class="text-xl font-semibold text-gray-900">{{ $calendarData['month_name'] }}</h2>
        </div>
        
        <div class="flex items-center space-x-2">
            <a href="{{ route('panel.events.schedule.index', array_merge(request()->query(), [
                'month' => $month == 1 ? 12 : $month - 1,
                'year' => $month == 1 ? $year - 1 : $year
            ])) }}" 
               class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            
            <a href="{{ route('panel.events.schedule.index', array_merge(request()->query(), [
                'month' => now()->month,
                'year' => now()->year
            ])) }}" 
               class="px-3 py-1 text-sm bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition">
                Hoje
            </a>
            
            <a href="{{ route('panel.events.schedule.index', array_merge(request()->query(), [
                'month' => $month == 12 ? 1 : $month + 1,
                'year' => $month == 12 ? $year + 1 : $year
            ])) }}" 
               class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Calendário -->
    <div class="grid grid-cols-7 gap-px bg-gray-200 rounded-lg overflow-hidden">
        <!-- Cabeçalho dos dias da semana -->
        <div class="bg-gray-50 px-3 py-2 text-center text-sm font-medium text-gray-500">Dom</div>
        <div class="bg-gray-50 px-3 py-2 text-center text-sm font-medium text-gray-500">Seg</div>
        <div class="bg-gray-50 px-3 py-2 text-center text-sm font-medium text-gray-500">Ter</div>
        <div class="bg-gray-50 px-3 py-2 text-center text-sm font-medium text-gray-500">Qua</div>
        <div class="bg-gray-50 px-3 py-2 text-center text-sm font-medium text-gray-500">Qui</div>
        <div class="bg-gray-50 px-3 py-2 text-center text-sm font-medium text-gray-500">Sex</div>
        <div class="bg-gray-50 px-3 py-2 text-center text-sm font-medium text-gray-500">Sáb</div>

        <!-- Dias do mês anterior -->
        @foreach($calendarData['prev_month_days'] as $day)
            <div class="bg-gray-50 p-2 min-h-[120px] text-gray-400">
                <div class="text-sm">{{ $day['day'] }}</div>
            </div>
        @endforeach

        <!-- Dias do mês atual -->
        @foreach($calendarData['current_month_days'] as $day)
            <div class="bg-white p-2 min-h-[120px] {{ $day['is_today'] ? 'bg-purple-50' : '' }} {{ $day['is_past'] ? 'bg-gray-50' : '' }}">
                <div class="flex items-center justify-between mb-1">
                    <div class="text-sm font-medium {{ $day['is_today'] ? 'text-purple-600' : 'text-gray-900' }}">
                        {{ $day['day'] }}
                    </div>
                    @if($day['events']->count() > 0)
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $day['events']->count() }}
                        </span>
                    @endif
                </div>
                
                <!-- Eventos do dia -->
                <div class="space-y-1">
                    @foreach($day['events']->take(3) as $event)
                        <div class="text-xs p-1 rounded cursor-pointer hover:bg-gray-100 transition
                            @switch($event->type)
                                @case('formatura') bg-blue-100 text-blue-800 hover:bg-blue-200 @break
                                @case('aniversario') bg-pink-100 text-pink-800 hover:bg-pink-200 @break
                                @case('casamento') bg-purple-100 text-purple-800 hover:bg-purple-200 @break
                                @case('carnaval') bg-yellow-100 text-yellow-800 hover:bg-yellow-200 @break
                                @case('corporativo') bg-gray-100 text-gray-800 hover:bg-gray-200 @break
                                @default bg-green-100 text-green-800 hover:bg-green-200 @break
                            @endswitch"
                            onclick="showEventModal({{ $event->id }})"
                            title="{{ $event->title }} - {{ $event->start_time->format('H:i') }}">
                            <div class="truncate">
                                {{ $event->start_time->format('H:i') }} {{ $event->title }}
                            </div>
                        </div>
                    @endforeach
                    
                    @if($day['events']->count() > 3)
                        <div class="text-xs text-gray-500 cursor-pointer hover:text-gray-700" 
                             onclick="showEventModal({{ $day['date']->format('Y-m-d') }})">
                            +{{ $day['events']->count() - 3 }} mais
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- Dias do próximo mês -->
        @foreach($calendarData['next_month_days'] as $day)
            <div class="bg-gray-50 p-2 min-h-[120px] text-gray-400">
                <div class="text-sm">{{ $day['day'] }}</div>
            </div>
        @endforeach
    </div>
</div>

<!-- Legenda -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
    <h3 class="text-sm font-medium text-gray-900 mb-3">Legenda</h3>
    <div class="flex flex-wrap gap-4">
        <div class="flex items-center">
            <div class="w-3 h-3 bg-blue-100 rounded mr-2"></div>
            <span class="text-sm text-gray-600">Formatura</span>
        </div>
        <div class="flex items-center">
            <div class="w-3 h-3 bg-pink-100 rounded mr-2"></div>
            <span class="text-sm text-gray-600">Aniversário</span>
        </div>
        <div class="flex items-center">
            <div class="w-3 h-3 bg-purple-100 rounded mr-2"></div>
            <span class="text-sm text-gray-600">Casamento</span>
        </div>
        <div class="flex items-center">
            <div class="w-3 h-3 bg-yellow-100 rounded mr-2"></div>
            <span class="text-sm text-gray-600">Carnaval</span>
        </div>
        <div class="flex items-center">
            <div class="w-3 h-3 bg-gray-100 rounded mr-2"></div>
            <span class="text-sm text-gray-600">Corporativo</span>
        </div>
        <div class="flex items-center">
            <div class="w-3 h-3 bg-green-100 rounded mr-2"></div>
            <span class="text-sm text-gray-600">Outro</span>
        </div>
    </div>
</div>
