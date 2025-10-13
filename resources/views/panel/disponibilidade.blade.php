@extends('panel.layout')

@section('page-title', 'Disponibilidade')
@section('page-subtitle', 'Defina seus horários de atendimento')

@section('header-actions')
    <a href="{{ route('panel.disponibilidade.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition inline-flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Adicionar Horário</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Horários Semanais -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Horários da Semana</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach([0 => 'Domingo', 1 => 'Segunda-feira', 2 => 'Terça-feira', 3 => 'Quarta-feira', 4 => 'Quinta-feira', 5 => 'Sexta-feira', 6 => 'Sábado'] as $day => $dayName)
                    @php
                        $dayAvailabilities = $availabilities->where('day_of_week', $day);
                    @endphp
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $dayName }}</p>
                            @if($dayAvailabilities->count() > 0)
                                <div class="mt-2 space-y-1">
                                    @foreach($dayAvailabilities as $avail)
                                        <div class="flex items-center justify-between text-sm text-gray-600">
                                            <span>{{ substr($avail->start_time, 0, 5) }} - {{ substr($avail->end_time, 0, 5) }} (Intervalos de {{ $avail->slot_duration }}min)</span>
                                            <form method="POST" action="{{ route('panel.disponibilidade.destroy', $avail) }}" class="inline" onsubmit="return confirm('Remover este horário?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 mt-1">Fechado</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Datas Bloqueadas -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Datas Bloqueadas</h3>
            <button onclick="document.getElementById('addBlockedDate').classList.toggle('hidden')" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                + Adicionar
            </button>
        </div>
        
        <!-- Formulário de adicionar data bloqueada (oculto por padrão) -->
        <div id="addBlockedDate" class="hidden px-6 py-4 bg-gray-50 border-b border-gray-200">
            <form method="POST" action="{{ route('panel.disponibilidade.blocked-dates.store') }}" class="flex space-x-4">
                @csrf
                <input type="date" name="blocked_date" required class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <input type="text" name="reason" placeholder="Motivo (opcional)" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    Adicionar
                </button>
            </form>
        </div>

        <div class="p-6">
            @forelse($blockedDates as $blocked)
                <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg mb-2">
                    <div>
                        <p class="font-medium text-gray-900">{{ $blocked->blocked_date->format('d/m/Y') }}</p>
                        @if($blocked->reason)
                            <p class="text-sm text-gray-600">{{ $blocked->reason }}</p>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('panel.disponibilidade.blocked-dates.destroy', $blocked) }}" onsubmit="return confirm('Remover bloqueio?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-center text-gray-500 py-4">Nenhuma data bloqueada</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

