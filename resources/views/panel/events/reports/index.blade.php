@extends('panel.layout')

@section('page-title', 'Relatórios de Eventos')
@section('page-subtitle', 'Análise completa dos seus eventos e performance')

@section('content')
<div class="space-y-6">
    <!-- Cards de Resumo -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total de Eventos</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Event::where('professional_id', Auth::user()->professional->id)->count() }}</p>
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
                    <p class="text-sm font-medium text-gray-500">Faturamento Total</p>
                    <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format(\App\Models\Event::where('professional_id', Auth::user()->professional->id)->get()->sum('total_invoiced'), 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pagamentos Recebidos</p>
                    <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format(\App\Models\Event::where('professional_id', Auth::user()->professional->id)->get()->sum('total_paid'), 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pendente</p>
                    <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format(\App\Models\Event::where('professional_id', Auth::user()->professional->id)->get()->sum('remaining_amount'), 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Relatórios Disponíveis -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Relatório Financeiro -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Relatório Financeiro</h3>
                    <p class="text-sm text-gray-500">Análise completa das finanças</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-4">Visualize faturamento, pagamentos, evolução mensal e top clientes.</p>
            <a href="{{ route('panel.events.reports.financial') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Ver Relatório
            </a>
        </div>

        <!-- Relatório de Equipamentos -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Equipamentos</h3>
                    <p class="text-sm text-gray-500">Uso e performance dos equipamentos</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-4">Analise quais equipamentos são mais utilizados e rentáveis.</p>
            <a href="{{ route('panel.events.reports.equipment') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Ver Relatório
            </a>
        </div>

        <!-- Relatório de Tipos de Eventos -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Tipos de Eventos</h3>
                    <p class="text-sm text-gray-500">Análise por categoria de evento</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-4">Veja quais tipos de eventos são mais populares e rentáveis.</p>
            <a href="{{ route('panel.events.reports.event-types') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Ver Relatório
            </a>
        </div>

        <!-- Relatório de Métodos de Pagamento -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Métodos de Pagamento</h3>
                    <p class="text-sm text-gray-500">Análise das formas de pagamento</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-4">Veja quais métodos de pagamento são mais utilizados pelos clientes.</p>
            <a href="{{ route('panel.events.reports.payment-methods') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Ver Relatório
            </a>
        </div>
    </div>

    <!-- Resumo Rápido -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Resumo Rápido</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Eventos Este Mês</h4>
                <p class="text-2xl font-semibold text-gray-900">
                    {{ \App\Models\Event::where('professional_id', Auth::user()->professional->id)
                        ->whereMonth('event_date', now()->month)
                        ->whereYear('event_date', now()->year)
                        ->count() }}
                </p>
            </div>
            
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Faturamento Este Mês</h4>
                <p class="text-2xl font-semibold text-gray-900">
                    R$ {{ number_format(\App\Models\Event::where('professional_id', Auth::user()->professional->id)
                        ->whereMonth('event_date', now()->month)
                        ->whereYear('event_date', now()->year)
                        ->get()->sum('total_invoiced'), 2, ',', '.') }}
                </p>
            </div>
            
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Ticket Médio</h4>
                <p class="text-2xl font-semibold text-gray-900">
                    @php
                        $totalEvents = \App\Models\Event::where('professional_id', Auth::user()->professional->id)->count();
                        $totalInvoiced = \App\Models\Event::where('professional_id', Auth::user()->professional->id)->get()->sum('total_invoiced');
                        $averageTicket = $totalEvents > 0 ? $totalInvoiced / $totalEvents : 0;
                    @endphp
                    R$ {{ number_format($averageTicket, 2, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
