@extends('panel.layout')

@section('page-title', 'Relatório de Equipamentos')
@section('page-subtitle', 'Análise de uso e performance dos equipamentos')

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
        
        <form method="GET" action="{{ route('panel.events.reports.equipment') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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

    <!-- Resumo dos Equipamentos -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total de Equipamentos</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $mostUsedEquipment->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total de Horas</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $hoursByEquipment->sum('total_hours') }}h</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Receita Total</p>
                    <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format($revenueByEquipment->sum('total_revenue'), 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Equipamentos Mais Usados -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Equipamentos Mais Usados</h3>
            
            @if($mostUsedEquipment->count() > 0)
                <div class="space-y-3">
                    @foreach($mostUsedEquipment as $equipment)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $equipment->equipment->name }}</p>
                                <p class="text-sm text-gray-600">{{ $equipment->usage_count }} utilizações</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">{{ $equipment->total_hours }}h</p>
                                <p class="text-sm text-gray-600">total</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Nenhum equipamento foi utilizado no período.</p>
            @endif
        </div>

        <!-- Receita por Equipamento -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Receita por Equipamento</h3>
            
            @if($revenueByEquipment->count() > 0)
                <div class="space-y-3">
                    @foreach($revenueByEquipment as $equipment)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $equipment->equipment->name }}</p>
                                <p class="text-sm text-gray-600">R$ {{ number_format($equipment->equipment->hourly_rate, 2, ',', '.') }}/h</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">R$ {{ number_format($equipment->total_revenue, 2, ',', '.') }}</p>
                                <p class="text-sm text-gray-600">receita</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Nenhuma receita encontrada no período.</p>
            @endif
        </div>
    </div>

    <!-- Horas Utilizadas por Equipamento -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Horas Utilizadas por Equipamento</h3>
        
        @if($hoursByEquipment->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipamento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor/Hora</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horas Utilizadas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receita Gerada</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eficiência</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($hoursByEquipment as $equipment)
                            @php
                                $revenue = $revenueByEquipment->where('equipment_id', $equipment->equipment_id)->first();
                                $revenueValue = $revenue ? $revenue->total_revenue : 0;
                                $efficiency = $equipment->total_hours > 0 ? ($revenueValue / $equipment->total_hours) : 0;
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $equipment->equipment->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $equipment->equipment->description ?? 'Sem descrição' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    R$ {{ number_format($equipment->equipment->hourly_rate, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $equipment->total_hours }}h
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    R$ {{ number_format($revenueValue, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $efficiency >= $equipment->equipment->hourly_rate ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        R$ {{ number_format($efficiency, 2, ',', '.') }}/h
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Nenhum equipamento foi utilizado no período.</p>
        @endif
    </div>

    <!-- Análise de Performance -->
    @if($mostUsedEquipment->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Análise de Performance</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Equipamento Mais Rentável</h4>
                    @php
                        $mostProfitable = $revenueByEquipment->first();
                    @endphp
                    @if($mostProfitable)
                        <div class="p-3 bg-green-50 rounded-lg">
                            <p class="font-medium text-green-900">{{ $mostProfitable->equipment->name }}</p>
                            <p class="text-sm text-green-700">R$ {{ number_format($mostProfitable->total_revenue, 2, ',', '.') }} em receita</p>
                        </div>
                    @endif
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Equipamento Mais Utilizado</h4>
                    @php
                        $mostUsed = $mostUsedEquipment->first();
                    @endphp
                    @if($mostUsed)
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <p class="font-medium text-blue-900">{{ $mostUsed->equipment->name }}</p>
                            <p class="text-sm text-blue-700">{{ $mostUsed->total_hours }}h de utilização</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
