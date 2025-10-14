@extends('panel.layout')

@section('page-title', 'Analytics de Serviços')
@section('page-subtitle', 'Análise de performance e comparecimento dos serviços')

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

<!-- Cards de Estatísticas -->
<div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total de Agendamentos</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_appointments']) }}</p>
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
                <p class="text-2xl font-bold text-green-600">{{ number_format($stats['attendance_rate'], 1) }}%</p>
                <p class="text-sm text-gray-500">{{ number_format($stats['completed_appointments']) }} concluídos</p>
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
                <p class="text-sm text-gray-500 mb-1">Taxa de Cancelamento</p>
                <p class="text-2xl font-bold text-red-600">{{ number_format($stats['cancellation_rate'], 1) }}%</p>
                <p class="text-sm text-gray-500">{{ number_format($stats['cancelled_appointments']) }} cancelados</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Não Comparecimento</p>
                <p class="text-2xl font-bold text-orange-600">{{ number_format($stats['no_show_rate'], 1) }}%</p>
                <p class="text-sm text-gray-500">{{ number_format($stats['no_show_appointments']) }} não compareceram</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos e Análises -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Top 5 Serviços Mais Agendados -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Top 5 Serviços Mais Agendados</h3>
            <a href="{{ route('panel.reports.services.most-booked', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
               class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                Ver todos →
            </a>
        </div>
        
        @if($mostBookedServices->count() > 0)
            <div class="space-y-3">
                @foreach($mostBookedServices->take(5) as $service)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-purple-600">#{{ $loop->iteration }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $service->name }}</p>
                                <p class="text-sm text-gray-500">{{ $service->total_appointments }} agendamentos</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">{{ $service->attendance_rate }}%</p>
                            <p class="text-sm text-gray-500">comparecimento</p>
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
    
    <!-- Agendamentos por Dia da Semana -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Agendamentos por Dia da Semana</h3>
        
        @if($appointmentsByDay->count() > 0)
            <div class="space-y-3">
                @php
                    $days = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
                    $maxCount = $appointmentsByDay->max();
                @endphp
                @foreach($days as $index => $day)
                    @php
                        $count = $appointmentsByDay[$index + 1] ?? 0;
                        $percentage = $maxCount > 0 ? ($count / $maxCount) * 100 : 0;
                    @endphp
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-blue-600">{{ $index + 1 }}</span>
                            </div>
                            <span class="font-medium text-gray-900">{{ $day }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-sm font-semibold text-gray-600 w-8 text-right">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p>Nenhum dado encontrado no período</p>
            </div>
        @endif
    </div>
</div>

<!-- Gráfico de Agendamentos por Hora -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Agendamentos por Hora do Dia</h3>
    
    @if($appointmentsByHour->count() > 0)
        <div class="h-64 flex items-end justify-between space-x-1">
            @php
                $maxHourly = $appointmentsByHour->max();
            @endphp
            @for($hour = 0; $hour < 24; $hour++)
                @php
                    $count = $appointmentsByHour[$hour] ?? 0;
                @endphp
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-gray-200 rounded-t-lg relative" style="height: {{ $maxHourly > 0 ? ($count / $maxHourly) * 200 : 0 }}px;">
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg"></div>
                        <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 text-xs font-semibold text-gray-700">
                            {{ $count }}
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 text-center">
                        {{ sprintf('%02d:00', $hour) }}
                    </div>
                </div>
            @endfor
        </div>
    @else
        <div class="text-center py-12 text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p>Nenhum dado de agendamento por hora encontrado</p>
        </div>
    @endif
</div>

<!-- Links para Relatórios Detalhados -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <a href="{{ route('panel.reports.services.most-booked', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Serviços Mais Agendados</h4>
                <p class="text-sm text-gray-500">Ranking completo de serviços</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('panel.reports.services.attendance-rate', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Taxa de Comparecimento</h4>
                <p class="text-sm text-gray-500">Análise detalhada de comparecimento</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('panel.reports.services.top-customers', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" 
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Clientes Mais Frequentes</h4>
                <p class="text-sm text-gray-500">Top clientes por agendamentos</p>
            </div>
        </div>
    </a>
</div>

@endsection
