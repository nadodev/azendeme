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
@endsection

