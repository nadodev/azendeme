@extends('panel.layout')

@section('page-title', 'Dashboard de Performance')
@section('page-subtitle', 'Visão geral completa do desempenho do negócio')

@section('content')

<!-- Filtros de Data -->
<div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Período de Análise</label>
            <div class="flex gap-2">
                <input type="date" 
                       name="date_from" 
                       value="{{ $dateFrom }}" 
                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <span class="flex items-center text-gray-500">até</span>
                <input type="date" 
                       name="date_to" 
                       value="{{ $dateTo }}" 
                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
        </div>
        
        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
            🔍 Analisar Período
        </button>
    </form>
</div>

<!-- Métricas Principais -->
<div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total de Agendamentos</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($metrics['total_appointments']) }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Taxa de Comparecimento</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($metrics['attendance_rate'], 1) }}%</p>
                <p class="text-sm text-gray-500">{{ number_format($metrics['completed_appointments']) }} concluídos</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Receita Total</p>
                <p class="text-2xl font-bold text-purple-600">R$ {{ number_format($metrics['total_revenue'], 2, ',', '.') }}</p>
                @if($revenue['revenue_growth'] != 0)
                    <p class="text-sm {{ $revenue['revenue_growth'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $revenue['revenue_growth'] > 0 ? '↗' : '↘' }} {{ abs($revenue['revenue_growth']) }}% vs anterior
                    </p>
                @endif
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Novos Clientes</p>
                <p class="text-2xl font-bold text-orange-600">{{ number_format($metrics['new_customers']) }}</p>
                <p class="text-sm text-gray-500">R$ {{ number_format($metrics['average_ticket'], 2, ',', '.') }} ticket médio</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Insights e Alertas -->
@if(count($insights) > 0)
<div class="mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">💡 Insights e Recomendações</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($insights as $insight)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 {{ $insight['type'] === 'warning' ? 'border-orange-200 bg-orange-50' : ($insight['type'] === 'success' ? 'border-green-200 bg-green-50' : 'border-blue-200 bg-blue-50') }}">
                <div class="flex items-start space-x-3">
                    <div class="text-2xl">{{ $insight['icon'] }}</div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">{{ $insight['title'] }}</h4>
                        <p class="text-gray-600 text-sm">{{ $insight['message'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Gráficos e Análises -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Performance de Serviços -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Top 5 Serviços</h3>
            <a href="{{ route('panel.reports.services.most-booked', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
               class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                Ver todos →
            </a>
        </div>
        
        @if(count($servicePerformance) > 0)
            <div class="space-y-3">
                @foreach($servicePerformance as $service)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-purple-600">#{{ $loop->iteration }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $service['name'] }}</p>
                                <p class="text-sm text-gray-500">{{ $service['total_appointments'] }} agendamentos</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">R$ {{ number_format($service['total_revenue'], 2, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">{{ $service['attendance_rate'] }}% comparecimento</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <p>Nenhum serviço encontrado no período</p>
            </div>
        @endif
    </div>
    
    <!-- Performance de Clientes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Clientes Mais Frequentes</h3>
            <a href="{{ route('panel.reports.services.top-customers', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
               class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                Ver todos →
            </a>
        </div>
        
        @if(count($customerPerformance['top_customers']) > 0)
            <div class="space-y-3">
                @foreach($customerPerformance['top_customers'] as $customer)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-blue-600">#{{ $loop->iteration }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $customer['name'] }}</p>
                                <p class="text-sm text-gray-500">{{ $customer['total_appointments'] }} agendamentos</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">{{ $customer['attendance_rate'] }}%</p>
                            <p class="text-sm text-gray-500">comparecimento</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <p>Nenhum cliente encontrado no período</p>
            </div>
        @endif
    </div>
</div>

<!-- Estatísticas de Clientes -->
<div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Estatísticas de Clientes</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="text-center p-4 bg-blue-50 rounded-lg">
            <div class="text-3xl font-bold text-blue-600 mb-2">{{ number_format($customerPerformance['stats']['total_customers']) }}</div>
            <div class="text-sm text-gray-600">Total de Clientes</div>
        </div>
        <div class="text-center p-4 bg-green-50 rounded-lg">
            <div class="text-3xl font-bold text-green-600 mb-2">{{ number_format($customerPerformance['stats']['active_customers']) }}</div>
            <div class="text-sm text-gray-600">Clientes Ativos</div>
        </div>
        <div class="text-center p-4 bg-orange-50 rounded-lg">
            <div class="text-3xl font-bold text-orange-600 mb-2">{{ number_format($customerPerformance['stats']['new_customers']) }}</div>
            <div class="text-sm text-gray-600">Novos Clientes</div>
        </div>
    </div>
</div>

<!-- Gráfico de Tendências -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">📈 Tendências (Últimos 30 Dias)</h3>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Agendamentos por Dia -->
        <div>
            <h4 class="font-medium text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Agendamentos por Dia
            </h4>
            <div class="h-64 flex items-end justify-between space-x-1 overflow-x-auto">
                @php
                    $maxAppointments = $trends['appointments_by_day']->max();
                @endphp
                @for($i = 0; $i < 30; $i++)
                    @php
                        $date = now()->subDays(29 - $i)->format('Y-m-d');
                        $count = $trends['appointments_by_day'][$date] ?? 0;
                        $height = $maxAppointments > 0 ? ($count / $maxAppointments) * 200 : 0;
                    @endphp
                    <div class="flex flex-col items-center min-w-0 flex-1">
                        <div class="w-full bg-gray-200 rounded-t-lg relative mb-2" style="height: {{ $height }}px; min-height: 4px;">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg transition-all duration-300 hover:from-blue-700 hover:to-blue-500"></div>
                            @if($count > 0)
                                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-semibold text-gray-700 bg-white px-1 rounded">
                                    {{ $count }}
                                </div>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 text-center transform -rotate-45 origin-left whitespace-nowrap">
                            {{ now()->subDays(29 - $i)->format('d/m') }}
                        </div>
                    </div>
                @endfor
            </div>
            @if($maxAppointments == 0)
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p>Nenhum agendamento nos últimos 30 dias</p>
                </div>
            @endif
        </div>
        
        <!-- Receita por Dia -->
        <div>
            <h4 class="font-medium text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
                Receita por Dia
            </h4>
            <div class="h-64 flex items-end justify-between space-x-1 overflow-x-auto">
                @php
                    $maxRevenue = $trends['revenue_by_day']->max();
                @endphp
                @for($i = 0; $i < 30; $i++)
                    @php
                        $date = now()->subDays(29 - $i)->format('Y-m-d');
                        $revenue = $trends['revenue_by_day'][$date] ?? 0;
                        $height = $maxRevenue > 0 ? ($revenue / $maxRevenue) * 200 : 0;
                    @endphp
                    <div class="flex flex-col items-center min-w-0 flex-1">
                        <div class="w-full bg-gray-200 rounded-t-lg relative mb-2" style="height: {{ $height }}px; min-height: 4px;">
                            <div class="absolute inset-0 bg-gradient-to-t from-green-600 to-green-400 rounded-t-lg transition-all duration-300 hover:from-green-700 hover:to-green-500"></div>
                            @if($revenue > 0)
                                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-semibold text-gray-700 bg-white px-1 rounded">
                                    R$ {{ number_format($revenue, 0, ',', '.') }}
                                </div>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 text-center transform -rotate-45 origin-left whitespace-nowrap">
                            {{ now()->subDays(29 - $i)->format('d/m') }}
                        </div>
                    </div>
                @endfor
            </div>
            @if($maxRevenue == 0)
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    <p>Nenhuma receita nos últimos 30 dias</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Legenda -->
    <div class="mt-6 flex justify-center space-x-6 text-sm text-gray-600">
        <div class="flex items-center">
            <div class="w-4 h-4 bg-blue-500 rounded mr-2"></div>
            <span>Agendamentos</span>
        </div>
        <div class="flex items-center">
            <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
            <span>Receita (R$)</span>
        </div>
    </div>
</div>

<!-- Links para Relatórios Detalhados -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <a href="{{ route('panel.reports.financial.dashboard', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Relatórios Financeiros</h4>
                <p class="text-sm text-gray-500">Receita e pagamentos</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('panel.reports.services.dashboard', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Analytics de Serviços</h4>
                <p class="text-sm text-gray-500">Performance e comparecimento</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('panel.alerts.index') }}" 
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 102.828 2.828L7.828 9.828a2 2 0 00-2.828-2.828L2.414 7.414A2 2 0 104.828 7z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Sistema de Alertas</h4>
                <p class="text-sm text-gray-500">Notificações e insights</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('panel.activity-logs.index') }}" 
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Logs de Atividade</h4>
                <p class="text-sm text-gray-500">Histórico de ações</p>
            </div>
        </div>
    </a>
</div>

@endsection
