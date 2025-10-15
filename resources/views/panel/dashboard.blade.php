@extends('panel.layout')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Visão geral do seu negócio')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <!-- Cards de Estatísticas Principais -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6">
        <!-- Receita do Mês -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-4 lg:p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-30 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium opacity-90">Mês Atual</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">R$ {{ number_format($financialStats['monthly_income'], 2, ',', '.') }}</h3>
            <p class="text-sm opacity-90">Receitas</p>
        </div>

        <!-- Lucro do Mês -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-4 lg:p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-30 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <span class="text-sm font-medium opacity-90">Lucro Líquido</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">R$ {{ number_format($financialStats['monthly_profit'], 2, ',', '.') }}</h3>
            <p class="text-sm opacity-90">{{ $financialStats['monthly_profit'] >= 0 ? 'Positivo' : 'Negativo' }}</p>
        </div>

        <!-- Agendamentos do Mês -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-4 lg:p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-30 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium opacity-90">Total</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $stats['total_appointments'] }}</h3>
            <p class="text-sm opacity-90">Agendamentos</p>
        </div>

        <!-- Total de Clientes -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-4 lg:p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-30 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium opacity-90">Cadastrados</span>
            </div>
            <h3 class="text-3xl font-bold mb-1">{{ $stats['total_customers'] }}</h3>
            <p class="text-sm opacity-90">Clientes</p>
        </div>
    </div>

    <!-- Cards Secundários -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Receita Hoje -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Receita Hoje</p>
                    <p class="text-2xl font-bold text-green-600">R$ {{ number_format($financialStats['today_income'], 2, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Agendamentos Pendentes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Pendentes</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_appointments'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Agendamentos Confirmados -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Confirmados</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['confirmed_appointments'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Próximos Agendamentos -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Próximos Agendamentos</h3>
                <a href="{{ route('panel.agenda.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                    Ver todos →
                </a>
            </div>

            @if($upcomingAppointments->count() > 0)
                <div class="space-y-4">
                    @foreach($upcomingAppointments as $appointment)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-lg">
                                    {{ substr($appointment->customer->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $appointment->customer->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $appointment->service->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $appointment->start_time->format('d/m/Y H:i') }} - {{ $appointment->service->duration }}min
                                    </p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $appointment->status === 'pending' ? 'Pendente' : 'Confirmado' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500">Nenhum agendamento próximo</p>
                </div>
            @endif
        </div>

        <!-- Top Serviços -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Serviços Mais Procurados</h3>

            @if($topServices->count() > 0)
                <div class="space-y-4">
                    @foreach($topServices as $index => $service)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ $service->name }}</p>
                                    <p class="text-xs text-gray-500">R$ {{ number_format($service->price, 2, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-purple-600">{{ $service->appointments_count }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Nenhum serviço agendado</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Agendamentos por Mês -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Agendamentos (Últimos 6 Meses)</h3>
            
            @if($monthlyAppointments->count() > 0)
                <div class="space-y-3">
                    @php
                        $maxAppointments = $monthlyAppointments->max('total');
                    @endphp
                    @foreach($monthlyAppointments as $month)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $month->month }}</span>
                                <span class="text-sm font-bold text-purple-600">{{ $month->total }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-3 rounded-full transition-all" style="width: {{ ($month->total / max($maxAppointments, 1)) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Nenhum dado disponível</p>
            @endif
        </div>

        <!-- Receita por Mês -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Receita (Últimos 6 Meses)</h3>
            
            @if($monthlyRevenue->count() > 0)
                <div class="space-y-3">
                    @php
                        $maxRevenue = $monthlyRevenue->max('total');
                    @endphp
                    @foreach($monthlyRevenue as $month)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $month->month }}</span>
                                <span class="text-sm font-bold text-green-600">R$ {{ number_format($month->total, 2, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all" style="width: {{ ($month->total / max($maxRevenue, 1)) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Nenhum dado disponível</p>
            @endif
        </div>
    </div>

    <!-- Status do Caixa -->
    @if($financialStats['cash_register'])
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <div>
                        <h3 class="text-xl font-bold">Caixa de Hoje</h3>
                        <p class="text-sm opacity-90">{{ date('d/m/Y') }}</p>
                    </div>
                </div>
                <span class="px-4 py-2 bg-white bg-opacity-20 rounded-lg text-sm font-semibold">
                    {{ $financialStats['cash_register']->status === 'open' ? '✓ Aberto' : '✗ Fechado' }}
                </span>
            </div>
            
            <div class="grid grid-cols-4 gap-4">
                <div>
                    <p class="text-sm opacity-90 mb-1">Saldo Inicial</p>
                    <p class="text-lg font-bold">R$ {{ number_format($financialStats['cash_register']->opening_balance, 2, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm opacity-90 mb-1">Entradas</p>
                    <p class="text-lg font-bold">R$ {{ number_format($financialStats['cash_register']->total_income, 2, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm opacity-90 mb-1">Saídas</p>
                    <p class="text-lg font-bold">R$ {{ number_format($financialStats['cash_register']->total_expense, 2, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm opacity-90 mb-1">Saldo Atual</p>
                    <p class="text-2xl font-bold">R$ {{ number_format($financialStats['cash_register']->net_balance, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div class="flex-1">
                    <p class="font-semibold text-yellow-800">Caixa não aberto hoje</p>
                    <p class="text-sm text-yellow-700 mt-1">Abra o caixa para começar a registrar transações do dia.</p>
                </div>
                <a href="{{ route('panel.financeiro.caixa') }}" class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition font-semibold">
                    Abrir Caixa
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
