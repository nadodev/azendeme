@extends('panel.layout')

@section('page-title', 'Dashboard Financeiro')
@section('page-subtitle', 'Visão geral da receita e pagamentos')

@section('content')

<!-- Filtros de Data -->
<div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Período</label>
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
        
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                🔍 Filtrar
            </button>
            <a href="{{ route('panel.reports.financial.export', ['type' => 'payments', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                📊 Exportar
            </a>
        </div>
    </form>
</div>

<!-- Cards de Métricas Principais -->
<div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Receita Total</p>
                <p class="text-2xl font-bold text-green-600">R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}</p>
                @if($stats['revenue_growth'] != 0)
                    <p class="text-sm {{ $stats['revenue_growth'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $stats['revenue_growth'] > 0 ? '↗' : '↘' }} {{ abs($stats['revenue_growth']) }}% vs período anterior
                    </p>
                @endif
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Agendamentos Concluídos</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_appointments']) }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Ticket Médio</p>
                <p class="text-2xl font-bold text-purple-600">R$ {{ number_format($stats['average_ticket'], 2, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Crescimento</p>
                <p class="text-2xl font-bold {{ $stats['revenue_growth'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $stats['revenue_growth'] > 0 ? '+' : '' }}{{ number_format($stats['revenue_growth'], 1) }}%
                </p>
            </div>
            <div class="w-12 h-12 {{ $stats['revenue_growth'] > 0 ? 'bg-green-100' : 'bg-red-100' }} rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 {{ $stats['revenue_growth'] > 0 ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos e Tabelas -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Receita por Método de Pagamento -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Receita por Método de Pagamento</h3>
        @if($revenueByPaymentMethod->count() > 0)
            <div class="space-y-4">
                @foreach($revenueByPaymentMethod as $method)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                @switch($method->name)
                                    @case('PIX')
                                        🏦
                                        @break
                                    @case('Cartão de Crédito')
                                        💳
                                        @break
                                    @case('Cartão de Débito')
                                        💳
                                        @break
                                    @case('Dinheiro')
                                        💵
                                        @break
                                    @default
                                        💰
                                @endswitch
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $method->name }}</p>
                                <p class="text-sm text-gray-500">{{ $method->count }} transações</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">R$ {{ number_format($method->total, 2, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $stats['total_revenue'] > 0 ? round(($method->total / $stats['total_revenue']) * 100, 1) : 0 }}%
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <p>Nenhum pagamento encontrado no período</p>
            </div>
        @endif
    </div>
    
    <!-- Top Serviços por Receita -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Serviços por Receita</h3>
        @if($revenueByService->count() > 0)
            <div class="space-y-4">
                @foreach($revenueByService->take(5) as $service)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-purple-600">#{{ $loop->iteration }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $service->name }}</p>
                                <p class="text-sm text-gray-500">{{ $service->count }} agendamentos</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">R$ {{ number_format($service->total, 2, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">
                                R$ {{ number_format($service->total / max(1, $service->count), 2, ',', '.') }} médio
                            </p>
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
</div>

<!-- Gráfico de Receita Mensal -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-900">Receita Mensal (Últimos 12 Meses)</h3>
        <div class="flex gap-2">
            <a href="{{ route('panel.reports.financial.monthly-revenue') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold text-sm">
                📊 Ver Detalhes
            </a>
        </div>
    </div>
    
    @if($monthlyRevenue->count() > 0)
        <div class="h-64 flex items-end justify-between space-x-2">
            @php
                $maxRevenue = $monthlyRevenue->max('total');
            @endphp
            @foreach($monthlyRevenue as $month)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-gray-200 rounded-t-lg relative" style="height: {{ $maxRevenue > 0 ? ($month->total / $maxRevenue) * 200 : 0 }}px;">
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg"></div>
                        <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 text-xs font-semibold text-gray-700">
                            R$ {{ number_format($month->total, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 text-center">
                        {{ \Carbon\Carbon::createFromFormat('Y-m', $month->month)->format('M/Y') }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <p>Nenhum dado de receita encontrado</p>
        </div>
    @endif
</div>

<!-- Links para Relatórios Detalhados -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <a href="{{ route('panel.reports.financial.payment-methods', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Métodos de Pagamento</h4>
                <p class="text-sm text-gray-500">Relatório detalhado por método</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('panel.reports.financial.revenue-by-service', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Receita por Serviço</h4>
                <p class="text-sm text-gray-500">Análise detalhada por serviço</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('panel.reports.financial.monthly-revenue') }}" 
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Receita Mensal</h4>
                <p class="text-sm text-gray-500">Análise temporal detalhada</p>
            </div>
        </div>
    </a>
</div>

@endsection
