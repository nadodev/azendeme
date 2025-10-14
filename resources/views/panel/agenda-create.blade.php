@extends('panel.layout')

@section('page-title', 'Novo Agendamento')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('panel.agenda.store') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cliente *</label>
            <select name="customer_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <option value="">Selecione o cliente</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Serviço *</label>
            <select name="service_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <option value="">Selecione o serviço</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }} ({{ $service->duration }}min)</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Data e Horário *</label>
            <input type="datetime-local" name="start_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
            <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"></textarea>
        </div>

        <!-- Agendamento Recorrente -->
        <div class="border-t border-gray-200 pt-6">
            <div class="flex items-center mb-4">
                <input type="checkbox" id="is_recurring" name="is_recurring" value="1" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500" onchange="toggleRecurrence()">
                <label for="is_recurring" class="ml-2 text-sm font-medium text-gray-900">Agendamento Recorrente</label>
            </div>

            <div id="recurrence-options" class="hidden space-y-4 ml-6 p-4 bg-gray-50 rounded-lg">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Repetir a cada</label>
                        <select name="recurrence_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="">Selecione...</option>
                            <option value="weekly">Semanalmente</option>
                            <option value="biweekly">Quinzenalmente</option>
                            <option value="monthly">Mensalmente</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Repetir quantas vezes?</label>
                        <input type="number" name="recurrence_interval" min="1" max="52" placeholder="Ex: 4 (repetições)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>

                <div class="text-xs text-gray-600 bg-blue-50 p-3 rounded border border-blue-200">
                    <svg class="w-4 h-4 inline-block mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Será criado um agendamento principal e os próximos automaticamente nas datas correspondentes.
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('panel.agenda.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                Criar Agendamento
            </button>
        </div>
    </form>
</div>

<script>
function toggleRecurrence() {
    const checkbox = document.getElementById('is_recurring');
    const options = document.getElementById('recurrence-options');
    
    if (checkbox.checked) {
        options.classList.remove('hidden');
    } else {
        options.classList.add('hidden');
    }
}
</script>
@endsection
