@extends('panel.layout')

@section('page-title', 'Analytics & Métricas')
@section('page-subtitle', 'Análise detalhada do desempenho do seu negócio')

@section('content')
<div class="space-y-6">
    <!-- Filtros de Período -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" class="flex items-end gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Data Inicial</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Data Final</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                Filtrar
            </button>
            <a href="{{ route('panel.analytics.export', ['start_date' => $startDate, 'end_date' => $endDate, 'format' => 'pdf']) }}" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                📄 Exportar PDF
            </a>
        </form>
    </div>

    <!-- Cards de Resumo -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Agendamentos -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="text-blue-100">Total de Agendamentos</div>
                <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="text-4xl font-bold mb-2">{{ $metrics['appointments']['total'] }}</div>
            <div class="text-sm text-blue-100">
                ✓ {{ $metrics['appointments']['completed'] }} concluídos ({{ $metrics['appointments']['completion_rate'] }}%)
            </div>
        </div>

        <!-- Receita -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="text-green-100">Receita Total</div>
                <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-4xl font-bold mb-2">R$ {{ number_format($metrics['revenue']['income'], 2, ',', '.') }}</div>
            <div class="text-sm text-green-100">
                Lucro: R$ {{ number_format($metrics['revenue']['profit'], 2, ',', '.') }}
            </div>
        </div>

        <!-- Clientes -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="text-purple-100">Clientes Ativos</div>
                <svg class="w-8 h-8 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="text-4xl font-bold mb-2">{{ $metrics['customers']['total_active'] }}</div>
            <div class="text-sm text-purple-100">
                {{ $metrics['customers']['new'] }} novos | {{ $metrics['customers']['returning'] }} retornaram
            </div>
        </div>

        <!-- Taxa de No-Show -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="text-orange-100">Taxa de No-Show</div>
                <svg class="w-8 h-8 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-4xl font-bold mb-2">{{ $metrics['appointments']['no_show_rate'] }}%</div>
            <div class="text-sm text-orange-100">
                {{ $metrics['appointments']['no_show'] }} faltas no período
            </div>
        </div>
    </div>

    <!-- Gráficos e Tabelas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Serviços Mais Vendidos -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Serviços Mais Vendidos
            </h3>
            <div class="space-y-3">
                @forelse($metrics['services'] as $service)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">{{ $service['service_name'] }}</div>
                            <div class="text-sm text-gray-500">{{ $service['count'] }} agendamentos</div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-green-600">R$ {{ number_format($service['revenue'], 2, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Nenhum serviço vendido no período</p>
                @endforelse
            </div>
        </div>

        <!-- Horários Mais Populares -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Horários Mais Populares
            </h3>
            <div class="space-y-3">
                @forelse($metrics['schedule']['popular_times'] as $time)
                    <div class="flex items-center">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">{{ $time['hour'] }}</div>
                        </div>
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-6">
                                <div class="bg-blue-600 h-6 rounded-full flex items-center justify-center text-xs text-white font-bold" style="width: {{ min(($time['count'] / max(array_column($metrics['schedule']['popular_times']->toArray(), 'count'))) * 100, 100) }}%">
                                    {{ $time['count'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Sem dados suficientes</p>
                @endforelse
            </div>
        </div>

        <!-- Dias da Semana Mais Ocupados -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Dias Mais Ocupados
            </h3>
            <div class="space-y-3">
                @forelse($metrics['schedule']['popular_days'] as $day)
                    <div class="flex items-center">
                        <div class="w-24 font-semibold text-gray-900">{{ $day['day'] }}</div>
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-6">
                                <div class="bg-green-600 h-6 rounded-full flex items-center justify-center text-xs text-white font-bold" style="width: {{ min(($day['count'] / max(array_column($metrics['schedule']['popular_days']->toArray(), 'count'))) * 100, 100) }}%">
                                    {{ $day['count'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Sem dados suficientes</p>
                @endforelse
            </div>
        </div>

        <!-- Resumo Financeiro -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Resumo Financeiro
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <span class="font-semibold text-gray-700">Receitas</span>
                    <span class="text-lg font-bold text-green-600">R$ {{ number_format($metrics['revenue']['income'], 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                    <span class="font-semibold text-gray-700">Despesas</span>
                    <span class="text-lg font-bold text-red-600">R$ {{ number_format($metrics['revenue']['expense'], 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg border-2 border-purple-200">
                    <span class="font-bold text-gray-900">Lucro Líquido</span>
                    <span class="text-2xl font-bold text-purple-600">R$ {{ number_format($metrics['revenue']['profit'], 2, ',', '.') }}</span>
                </div>
                <div class="text-sm text-gray-600 text-center pt-2 border-t border-gray-200">
                    Ticket Médio: R$ {{ number_format($metrics['revenue']['avg_transaction'], 2, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

