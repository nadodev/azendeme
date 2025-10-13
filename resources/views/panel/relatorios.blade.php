@extends('panel.layout')

@section('page-title', 'Relatórios')
@section('page-subtitle', 'Visualize a performance do seu negócio')

@section('content')
<div class="space-y-6">
    <!-- Filtro de Período -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('panel.relatorios.index') }}" class="flex items-end space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Data Inicial</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Data Final</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>
            <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                Aplicar
            </button>
        </form>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Agendamentos</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalAppointments }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Taxa de Cancelamento</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $cancellationRate }}%</p>
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
                    <p class="text-sm font-medium text-gray-600">Receita Estimada</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">R$ {{ number_format($estimatedRevenue, 2, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Agendamentos por Status -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Agendamentos por Status</h3>
        <div class="space-y-3">
            @foreach($appointmentsByStatus as $item)
                @php
                    $statusColors = [
                        'pending' => ['bg' => 'bg-amber-500', 'text' => 'Pendente'],
                        'confirmed' => ['bg' => 'bg-green-500', 'text' => 'Confirmado'],
                        'cancelled' => ['bg' => 'bg-red-500', 'text' => 'Cancelado'],
                        'completed' => ['bg' => 'bg-indigo-500', 'text' => 'Concluído'],
                    ];
                    $color = $statusColors[$item->status] ?? ['bg' => 'bg-gray-500', 'text' => $item->status];
                @endphp
                <div>
                    <div class="flex items-center justify-between text-sm mb-1">
                        <span class="text-gray-600">{{ $color['text'] }}</span>
                        <span class="font-semibold text-gray-900">{{ $item->total }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="{{ $color['bg'] }} h-2.5 rounded-full" style="width: {{ ($item->total / max($totalAppointments, 1)) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Serviços Mais Procurados -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Serviços Mais Procurados</h3>
        <div class="space-y-4">
            @forelse($topServices as $item)
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $item->service->name }}</p>
                        <div class="mt-1 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-purple-600 to-pink-500 h-2 rounded-full" style="width: {{ ($item->total / $topServices->max('total')) * 100 }}%"></div>
                        </div>
                    </div>
                    <span class="ml-4 text-lg font-bold text-gray-900">{{ $item->total }}</span>
                </div>
            @empty
                <p class="text-center text-gray-500 py-4">Sem dados no período selecionado</p>
            @endforelse
        </div>
    </div>

    <!-- Horários de Pico -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Horários de Pico</h3>
        <div class="grid grid-cols-5 gap-4">
            @forelse($peakHours as $hour)
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <p class="text-2xl font-bold text-purple-600">{{ $hour->hour }}h</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $hour->total }} agendamentos</p>
                </div>
            @empty
                <div class="col-span-5 text-center text-gray-500 py-4">Sem dados no período selecionado</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

