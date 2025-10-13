@extends('panel.layout')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Visão geral do seu negócio')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Agendamentos -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Agendamentos</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_appointments'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pendentes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pendentes</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">{{ $stats['pending_appointments'] }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Clientes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Clientes</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['total_customers'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Serviços -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Serviços Ativos</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['total_services'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Próximos Agendamentos -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Próximos Agendamentos</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($upcomingAppointments as $appointment)
                <div class="px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-semibold text-sm">{{ substr($appointment->customer->name, 0, 2) }}</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">{{ $appointment->customer->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $appointment->service->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $appointment->start_time->format('d/m/Y H:i') }} - {{ $appointment->service->duration }}min</p>
                            </div>
                        </div>
                        <div>
                            @if($appointment->status === 'confirmed')
                                <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Confirmado</span>
                            @elseif($appointment->status === 'pending')
                                <span class="px-3 py-1 text-xs font-semibold text-amber-700 bg-amber-100 rounded-full">Pendente</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500">Nenhum agendamento próximo</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Gráfico de Agendamentos Mensais -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Agendamentos (Últimos 6 Meses)</h3>
        <div class="space-y-3">
            @foreach($monthlyStats as $stat)
                <div>
                    <div class="flex items-center justify-between text-sm mb-1">
                        <span class="text-gray-600">{{ \Carbon\Carbon::parse($stat->month)->format('M/Y') }}</span>
                        <span class="font-semibold text-gray-900">{{ $stat->total }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-gradient-to-r from-purple-600 to-pink-500 h-2.5 rounded-full" style="width: {{ min(($stat->total / max($monthlyStats->max('total'), 1)) * 100, 100) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

