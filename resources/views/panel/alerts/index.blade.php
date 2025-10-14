@extends('panel.layout')

@section('page-title', 'Alertas')
@section('page-subtitle', 'Notificações e alertas do sistema')

@section('content')

<!-- Cards de Estatísticas -->
<div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total de Alertas</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_alerts']) }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 102.828 2.828L7.828 9.828a2 2 0 00-2.828-2.828L2.414 7.414A2 2 0 104.828 7z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Não Lidos</p>
                <p class="text-2xl font-bold text-orange-600">{{ number_format($stats['unread_alerts']) }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Alta Prioridade</p>
                <p class="text-2xl font-bold text-red-600">{{ number_format($stats['high_priority_alerts']) }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Urgentes</p>
                <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['urgent_alerts']) }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
            <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">Todos os tipos</option>
                @foreach($alertTypes as $value => $label)
                    <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Prioridade</label>
            <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">Todas as prioridades</option>
                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Baixa</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Média</option>
                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgente</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">Todos os status</option>
                <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Não Lidos</option>
                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Lidos</option>
                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Arquivados</option>
            </select>
        </div>
        
        <div class="flex items-end gap-2">
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                Filtrar
            </button>
            <a href="{{ route('panel.alerts.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                Limpar
            </a>
        </div>
    </form>
</div>

<!-- Lista de Alertas -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900">Alertas Recentes</h3>
        <div class="flex gap-2">
            <button onclick="markAllAsRead()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold text-sm">
                📖 Marcar Todos como Lidos
            </button>
            <a href="{{ route('panel.alerts.settings') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-semibold text-sm">
                ⚙️ Configurações
            </a>
        </div>
    </div>
    
    @if($alerts->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($alerts as $alert)
                <div class="p-6 hover:bg-gray-50 transition {{ $alert->status === 'unread' ? 'bg-blue-50 border-l-4 border-blue-400' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-4 flex-1">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-lg">
                                    {{ $alert->type_icon }}
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $alert->title }}</h4>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $alert->priority_color }}">
                                        {{ $alert->priority_name }}
                                    </span>
                                    @if($alert->status === 'unread')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Não Lido
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-gray-600 mb-3">{{ $alert->message }}</p>
                                
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $alert->created_at->format('d/m/Y H:i') }}
                                    
                                    @if($alert->data && isset($alert->data['appointment_id']))
                                        <span class="mx-2">•</span>
                                        <a href="{{ route('panel.agenda.edit', $alert->data['appointment_id']) }}" 
                                           class="text-blue-600 hover:text-blue-700 font-medium">
                                            Ver Agendamento
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 ml-4">
                            @if($alert->status === 'unread')
                                <button onclick="markAsRead({{ $alert->id }})" 
                                        class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                                    Marcar como Lido
                                </button>
                            @endif
                            
                            <button onclick="archiveAlert({{ $alert->id }})" 
                                    class="px-3 py-1 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-semibold">
                                Arquivar
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Paginação -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $alerts->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhum alerta encontrado</h3>
            <p class="text-gray-500">Não há alertas para os filtros selecionados.</p>
        </div>
    @endif
</div>

<script>
function markAsRead(alertId) {
    fetch(`/panel/alertas/${alertId}/marcar-lido`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Erro:', error));
}

function markAllAsRead() {
    if (confirm('Tem certeza que deseja marcar todos os alertas como lidos?')) {
        fetch('/panel/alertas/marcar-todos-lidos', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Erro:', error));
    }
}

function archiveAlert(alertId) {
    if (confirm('Tem certeza que deseja arquivar este alerta?')) {
        fetch(`/panel/alertas/${alertId}/arquivar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Erro:', error));
    }
}
</script>

@endsection
