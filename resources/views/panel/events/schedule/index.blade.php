@extends('panel.layout')

@section('page-title', 'Agenda de Eventos')
@section('page-subtitle', 'Visualize e gerencie seus eventos')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('panel.events.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <span>Novo Evento</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filtros e Controles -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <!-- Filtros -->
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <form method="GET" action="{{ route('panel.events.schedule.index') }}" class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                    <input type="hidden" name="view" value="{{ $view }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <input type="hidden" name="year" value="{{ $year }}">
                    
                    <select name="type" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Todos os tipos</option>
                        @foreach($eventTypes as $eventType)
                            <option value="{{ $eventType['value'] }}" {{ $type === $eventType['value'] ? 'selected' : '' }}>
                                {{ $eventType['label'] }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Todos os status</option>
                        @foreach($eventStatuses as $eventStatus)
                            <option value="{{ $eventStatus['value'] }}" {{ $status === $eventStatus['value'] ? 'selected' : '' }}>
                                {{ $eventStatus['label'] }}
                            </option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Filtrar
                    </button>
                </form>
            </div>

            <!-- Alternar Visualização -->
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">Visualização:</span>
                <div class="flex bg-gray-100 rounded-lg p-1">
                    <a href="{{ route('panel.events.schedule.index', array_merge(request()->query(), ['view' => 'calendar'])) }}" 
                       class="px-3 py-1 text-sm rounded-md transition {{ $view === 'calendar' ? 'bg-white text-purple-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Calendário
                    </a>
                    <a href="{{ route('panel.events.schedule.index', array_merge(request()->query(), ['view' => 'list'])) }}" 
                       class="px-3 py-1 text-sm rounded-md transition {{ $view === 'list' ? 'bg-white text-purple-600 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        Lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas do Mês -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['total_events'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Confirmados</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['confirmed_events'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Pendentes</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['pending_events'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Concluídos</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $stats['completed_events'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Receita</p>
                    <p class="text-lg font-semibold text-gray-900">R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($view === 'calendar')
        @include('panel.events.schedule.calendar')
    @else
        @include('panel.events.schedule.list')
    @endif
</div>

<!-- Modal para detalhes do evento -->
<div id="eventModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Detalhes do Evento</h3>
                <button onclick="closeEventModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div id="modalContent">
                <!-- Conteúdo será preenchido via JavaScript -->
            </div>
        </div>
    </div>
</div>

<script>
function showEventModal(eventId) {
    // Buscar detalhes do evento via AJAX
    fetch(`/panel/eventos/agenda/eventos-data?date=${eventId}`)
        .then(response => response.json())
        .then(data => {
            if (data.events && data.events.length > 0) {
                const event = data.events[0]; // Assumindo que queremos o primeiro evento
                document.getElementById('modalTitle').textContent = event.title;
                
                const content = `
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Cliente</label>
                                <p class="text-sm text-gray-900">${event.customer}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Tipo</label>
                                <p class="text-sm text-gray-900">${event.type}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Horário</label>
                                <p class="text-sm text-gray-900">${event.start_time} - ${event.end_time}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    ${event.status}
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <a href="/panel/eventos/${eventId}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                `;
                
                document.getElementById('modalContent').innerHTML = content;
                document.getElementById('eventModal').classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Erro ao carregar detalhes do evento:', error);
        });
}

function closeEventModal() {
    document.getElementById('eventModal').classList.add('hidden');
}

// Fechar modal ao clicar fora
document.getElementById('eventModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEventModal();
    }
});
</script>
@endsection
