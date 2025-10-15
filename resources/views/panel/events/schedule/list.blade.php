<!-- Visualização em Lista -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Cabeçalho da Lista -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Lista de Eventos</h3>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">{{ $events->count() }} eventos encontrados</span>
            </div>
        </div>
    </div>

    @if($events->count() > 0)
        <!-- Lista de Eventos -->
        <div class="divide-y divide-gray-200">
            @foreach($events as $event)
                <div class="p-6 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h4 class="text-lg font-medium text-gray-900">{{ $event->title }}</h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @switch($event->type)
                                        @case('formatura') bg-blue-100 text-blue-800 @break
                                        @case('aniversario') bg-pink-100 text-pink-800 @break
                                        @case('casamento') bg-purple-100 text-purple-800 @break
                                        @case('carnaval') bg-yellow-100 text-yellow-800 @break
                                        @case('corporativo') bg-gray-100 text-gray-800 @break
                                        @default bg-green-100 text-green-800 @break
                                    @endswitch">
                                    @switch($event->type)
                                        @case('formatura') 🎓 @break
                                        @case('aniversario') 🎂 @break
                                        @case('casamento') 💒 @break
                                        @case('carnaval') 🎭 @break
                                        @case('corporativo') 🏢 @break
                                        @default 🎉 @break
                                    @endswitch
                                    {{ ucfirst($event->type) }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @switch($event->status)
                                        @case('orcamento') bg-yellow-100 text-yellow-800 @break
                                        @case('confirmado') bg-green-100 text-green-800 @break
                                        @case('concluido') bg-blue-100 text-blue-800 @break
                                        @case('cancelado') bg-red-100 text-red-800 @break
                                        @default bg-gray-100 text-gray-800 @break
                                    @endswitch">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="font-medium text-gray-900">{{ $event->customer->name }}</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $event->event_date->format('d/m/Y') }}</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $event->address }}</span>
                                </div>
                            </div>
                            
                            @if($event->description)
                                <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $event->description }}</p>
                            @endif
                            
                            <!-- Equipamentos -->
                            @if($event->services->count() > 0)
                                <div class="mt-3">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Equipamentos:</span>
                                    </div>
                                    <div class="mt-1 flex flex-wrap gap-2">
                                        @foreach($event->services as $service)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $service->equipment->name }} ({{ $service->hours }}h)
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Ordem de Serviço -->
                            @if($event->serviceOrders->count() > 0)
                                <div class="mt-3">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Ordem de Serviço:</span>
                                        @foreach($event->serviceOrders as $serviceOrder)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                @switch($serviceOrder->status)
                                                    @case('pendente') bg-yellow-100 text-yellow-800 @break
                                                    @case('em_andamento') bg-blue-100 text-blue-800 @break
                                                    @case('concluida') bg-green-100 text-green-800 @break
                                                    @case('cancelada') bg-red-100 text-red-800 @break
                                                    @default bg-gray-100 text-gray-800 @break
                                                @endswitch">
                                                {{ ucfirst($serviceOrder->status) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-2 ml-4">
                            <div class="text-right">
                                <div class="text-lg font-semibold text-gray-900">
                                    R$ {{ number_format($event->final_value, 2, ',', '.') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $event->services->sum('hours') }}h total
                                </div>
                            </div>
                            
                            <div class="flex flex-col space-y-1">
                                <a href="{{ route('panel.events.show', $event) }}" 
                                   class="px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded hover:bg-purple-200 transition">
                                    Ver
                                </a>
                                <a href="{{ route('panel.events.edit', $event) }}" 
                                   class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">
                                    Editar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Estado vazio -->
        <div class="p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum evento encontrado</h3>
            <p class="mt-1 text-sm text-gray-500">
                @if($type || $status)
                    Tente ajustar os filtros para ver mais eventos.
                @else
                    Comece criando um novo evento.
                @endif
            </p>
            <div class="mt-6">
                <a href="{{ route('panel.events.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Novo Evento
                </a>
            </div>
        </div>
    @endif
</div>
