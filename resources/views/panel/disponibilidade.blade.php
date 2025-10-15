@extends('panel.layout')

@section('page-title', 'Disponibilidade & Horários')
@section('page-subtitle', 'Configure seus dias e horários de trabalho')

@section('content')

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Horários de Funcionamento -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Horários de Funcionamento
        </h3>

        <form action="{{ route('panel.disponibilidade.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dia da Semana *</label>
                <select name="day_of_week" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Selecione o dia</option>
                    <option value="0">Domingo</option>
                    <option value="1">Segunda-feira</option>
                    <option value="2">Terça-feira</option>
                    <option value="3">Quarta-feira</option>
                    <option value="4">Quinta-feira</option>
                    <option value="5">Sexta-feira</option>
                    <option value="6">Sábado</option>
                </select>
                @error('day_of_week')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hora Início *</label>
                    <input type="time" name="start_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('start_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hora Fim *</label>
                    <input type="time" name="end_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('end_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Intervalo entre horários (minutos) *</label>
                <select name="slot_duration" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="15">15 minutos</option>
                    <option value="30" selected>30 minutos</option>
                    <option value="45">45 minutos</option>
                    <option value="60">1 hora</option>
                </select>
                @error('slot_duration')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                Adicionar Horário
            </button>
        </form>

        <!-- Lista de Horários Cadastrados -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="font-semibold text-gray-900 mb-3">Horários Cadastrados</h4>
            @php
                $daysOfWeek = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
            @endphp

            @if($availabilities->count() > 0)
                <div class="space-y-2">
                    @foreach($availabilities as $avail)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium text-gray-900">{{ $daysOfWeek[$avail->day_of_week] }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ substr($avail->start_time, 0, 5) }} - {{ substr($avail->end_time, 0, 5) }}
                                    <span class="text-gray-400">•</span>
                                    Intervalo: {{ $avail->slot_duration }}min
                                </div>
                            </div>
                            <form action="{{ route('panel.disponibilidade.destroy', $avail->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este horário?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">Nenhum horário cadastrado ainda.</p>
            @endif
        </div>
    </div>

    <!-- Datas Bloqueadas -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
            Datas Bloqueadas
        </h3>
        <p class="text-sm text-gray-600 mb-4">Bloqueie datas específicas como férias, feriados ou dias de folga.</p>

        <form action="{{ route('panel.disponibilidade.blocked-dates.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Data *</label>
                <input type="date" name="blocked_date" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                @error('blocked_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Motivo (opcional)</label>
                <input type="text" name="reason" placeholder="Ex: Feriado, Férias, etc." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                @error('reason')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                Bloquear Data
            </button>
        </form>

        <!-- Lista de Datas Bloqueadas -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="font-semibold text-gray-900 mb-3">Datas Bloqueadas</h4>
            @php
                $blockedDates = \App\Models\BlockedDate::where('professional_id', 1)->orderBy('blocked_date')->get();
            @endphp

            @if($blockedDates->count() > 0)
                <div class="space-y-2">
                    @foreach($blockedDates as $blocked)
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                            <div>
                                <div class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($blocked->blocked_date)->format('d/m/Y') }}
                                    <span class="text-gray-400">•</span>
                                    {{ \Carbon\Carbon::parse($blocked->blocked_date)->locale('pt_BR')->dayName }}
                                </div>
                                @if($blocked->reason)
                                    <div class="text-sm text-gray-500">{{ $blocked->reason }}</div>
                                @endif
                            </div>
                            <form action="{{ route('panel.disponibilidade.blocked-dates.destroy', $blocked->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja desbloquear esta data?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">Nenhuma data bloqueada.</p>
            @endif
        </div>
    </div>
</div>

<!-- Dica -->
<div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
    <div class="flex items-start">
        <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
        <div>
            <h4 class="font-semibold text-blue-900 mb-1">Dica</h4>
            <p class="text-sm text-blue-800">
                Configure todos os seus dias e horários de trabalho. O intervalo entre horários define quando os clientes poderão agendar. 
                Por exemplo, com intervalo de 30 minutos, se você trabalha das 09:00 às 18:00, os horários disponíveis serão: 09:00, 09:30, 10:00, etc.
            </p>
        </div>
    </div>
</div>
@endsection
