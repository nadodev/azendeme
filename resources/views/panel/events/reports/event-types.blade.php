@extends('panel.layout')

@section('page-title', 'Relatório de Tipos de Eventos')
@section('page-subtitle', 'Análise por categoria de evento')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('panel.events.reports.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Voltar</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Filtros</h3>
        
        <form method="GET" action="{{ route('panel.events.reports.event-types') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Data Inicial</label>
                <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Data Final</label>
                <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    Aplicar Filtros
                </button>
            </div>
        </form>
    </div>

    <!-- Resumo dos Tipos de Eventos -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total de Eventos</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $eventsByType->sum('count') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Receita Total</p>
                    <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format($revenueByEventType->sum('total_revenue'), 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Ticket Médio</p>
                    @php
                        $totalEvents = $eventsByType->sum('count');
                        $totalRevenue = $revenueByEventType->sum('total_revenue');
                        $averageTicket = $totalEvents > 0 ? $totalRevenue / $totalEvents : 0;
                    @endphp
                    <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format($averageTicket, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Eventos por Tipo -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Eventos por Tipo</h3>
            
            @if($eventsByType->count() > 0)
                <div class="space-y-3">
                    @foreach($eventsByType as $eventType)
                        @php
                            $percentage = $eventsByType->sum('count') > 0 ? ($eventType->count / $eventsByType->sum('count')) * 100 : 0;
                        @endphp
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @switch($eventType->type)
                                            @case('formatura') bg-blue-100 text-blue-800 @break
                                            @case('aniversario') bg-pink-100 text-pink-800 @break
                                            @case('casamento') bg-purple-100 text-purple-800 @break
                                            @case('carnaval') bg-yellow-100 text-yellow-800 @break
                                            @case('corporativo') bg-gray-100 text-gray-800 @break
                                            @default bg-green-100 text-green-800 @break
                                        @endswitch">
                                        @switch($eventType->type)
                                            @case('formatura') 🎓 @break
                                            @case('aniversario') 🎂 @break
                                            @case('casamento') 💒 @break
                                            @case('carnaval') 🎭 @break
                                            @case('corporativo') 🏢 @break
                                            @default 🎉 @break
                                        @endswitch
                                        {{ ucfirst($eventType->type) }}
                                    </span>
                                    <span class="ml-3 text-sm text-gray-600">{{ $eventType->count }} eventos</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ number_format($percentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Nenhum evento encontrado no período.</p>
            @endif
        </div>

        <!-- Receita por Tipo de Evento -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Receita por Tipo de Evento</h3>
            
            @if($revenueByEventType->count() > 0)
                <div class="space-y-3">
                    @foreach($revenueByEventType as $eventType)
                        @php
                            $totalRevenue = $revenueByEventType->sum('total_revenue');
                            $percentage = $totalRevenue > 0 ? ($eventType->total_revenue / $totalRevenue) * 100 : 0;
                        @endphp
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @switch($eventType->type)
                                            @case('formatura') bg-blue-100 text-blue-800 @break
                                            @case('aniversario') bg-pink-100 text-pink-800 @break
                                            @case('casamento') bg-purple-100 text-purple-800 @break
                                            @case('carnaval') bg-yellow-100 text-yellow-800 @break
                                            @case('corporativo') bg-gray-100 text-gray-800 @break
                                            @default bg-green-100 text-green-800 @break
                                        @endswitch">
                                        @switch($eventType->type)
                                            @case('formatura') 🎓 @break
                                            @case('aniversario') 🎂 @break
                                            @case('casamento') 💒 @break
                                            @case('carnaval') 🎭 @break
                                            @case('corporativo') 🏢 @break
                                            @default 🎉 @break
                                        @endswitch
                                        {{ ucfirst($eventType->type) }}
                                    </span>
                                </div>
                                <span class="text-sm font-medium text-gray-900">R$ {{ number_format($eventType->total_revenue, 2, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Nenhuma receita encontrada no período.</p>
            @endif
        </div>
    </div>

    <!-- Eventos por Mês -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Eventos por Mês</h3>
        
        @if($eventsByMonth->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mês</th>
                            @foreach($eventsByType as $eventType)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ ucfirst($eventType->type) }}
                                </th>
                            @endforeach
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $months = $eventsByMonth->groupBy('month');
                        @endphp
                        @foreach($months as $month => $events)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('m/Y') }}
                                </td>
                                @foreach($eventsByType as $eventType)
                                    @php
                                        $monthEvent = $events->where('type', $eventType->type)->first();
                                        $count = $monthEvent ? $monthEvent->count : 0;
                                    @endphp
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $count }}
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $events->sum('count') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Nenhum evento encontrado no período.</p>
        @endif
    </div>

    <!-- Análise de Performance -->
    @if($eventsByType->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Análise de Performance</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Tipo Mais Popular</h4>
                    @php
                        $mostPopular = $eventsByType->first();
                    @endphp
                    @if($mostPopular)
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <p class="font-medium text-blue-900">{{ ucfirst($mostPopular->type) }}</p>
                            <p class="text-sm text-blue-700">{{ $mostPopular->count }} eventos ({{ number_format(($mostPopular->count / $eventsByType->sum('count')) * 100, 1) }}%)</p>
                        </div>
                    @endif
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Tipo Mais Rentável</h4>
                    @php
                        $mostProfitable = $revenueByEventType->first();
                    @endphp
                    @if($mostProfitable)
                        <div class="p-3 bg-green-50 rounded-lg">
                            <p class="font-medium text-green-900">{{ ucfirst($mostProfitable->type) }}</p>
                            <p class="text-sm text-green-700">R$ {{ number_format($mostProfitable->total_revenue, 2, ',', '.') }}</p>
                        </div>
                    @endif
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Ticket Médio Mais Alto</h4>
                    @php
                        $highestTicket = $revenueByEventType->map(function($item) use ($eventsByType) {
                            $eventCount = $eventsByType->where('type', $item->type)->first()->count ?? 1;
                            return [
                                'type' => $item->type,
                                'average' => $item->total_revenue / $eventCount
                            ];
                        })->sortByDesc('average')->first();
                    @endphp
                    @if($highestTicket)
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <p class="font-medium text-purple-900">{{ ucfirst($highestTicket['type']) }}</p>
                            <p class="text-sm text-purple-700">R$ {{ number_format($highestTicket['average'], 2, ',', '.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
