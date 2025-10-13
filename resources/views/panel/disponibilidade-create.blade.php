@extends('panel.layout')

@section('page-title', 'Adicionar Horário')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('panel.disponibilidade.store') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Dia da Semana *</label>
            <select name="day_of_week" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                @foreach($daysOfWeek as $value => $name)
                    <option value="{{ $value }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Horário Inicial *</label>
                <input type="time" name="start_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Horário Final *</label>
                <input type="time" name="end_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Intervalo entre atendimentos (minutos) *</label>
            <input type="number" name="slot_duration" value="30" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            <p class="text-xs text-gray-500 mt-1">Define os horários disponíveis para agendamento</p>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('panel.disponibilidade.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                Adicionar Horário
            </button>
        </div>
    </form>
</div>
@endsection

