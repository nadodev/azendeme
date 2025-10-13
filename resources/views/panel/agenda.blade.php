@extends('panel.layout')

@section('page-title', 'Agenda')
@section('page-subtitle', 'Gerencie todos os seus agendamentos')

@section('header-actions')
    <a href="{{ route('panel.agenda.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition inline-flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Novo Agendamento</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('panel.agenda.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Data</label>
                <input type="date" name="date" value="{{ $date }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Serviço</label>
                <select name="service_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Todos os serviços</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Todos os status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluído</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Agendamentos -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="divide-y divide-gray-200">
            @forelse($appointments as $appointment)
                <div class="px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 text-center">
                                <p class="text-xs font-medium text-gray-500">{{ $appointment->start_time->format('H:i') }}</p>
                                <p class="text-xs text-gray-400">{{ $appointment->service->duration }}min</p>
                            </div>
                            <div class="w-1 h-12 rounded-full" style="background-color: {{ ['pending' => '#f59e0b', 'confirmed' => '#10b981', 'cancelled' => '#ef4444', 'completed' => '#6366f1'][appointment->status] ?? '#6b7280' }}"></div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h4 class="text-sm font-semibold text-gray-900">{{ $appointment->customer->name }}</h4>
                                    @if($appointment->status === 'pending')
                                        <span class="px-2 py-0.5 text-xs font-semibold text-amber-700 bg-amber-100 rounded-full">Pendente</span>
                                    @elseif($appointment->status === 'confirmed')
                                        <span class="px-2 py-0.5 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Confirmado</span>
                                    @elseif($appointment->status === 'cancelled')
                                        <span class="px-2 py-0.5 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Cancelado</span>
                                    @elseif($appointment->status === 'completed')
                                        <span class="px-2 py-0.5 text-xs font-semibold text-indigo-700 bg-indigo-100 rounded-full">Concluído</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600">{{ $appointment->service->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $appointment->customer->phone }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('panel.agenda.edit', $appointment) }}" class="px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('panel.agenda.destroy', $appointment) }}" onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500">Nenhum agendamento encontrado</p>
                    <a href="{{ route('panel.agenda.create') }}" class="mt-4 inline-flex items-center text-purple-600 hover:text-purple-700 font-medium text-sm">
                        Criar primeiro agendamento
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
