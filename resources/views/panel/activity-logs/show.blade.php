@extends('panel.layout')

@section('page-title', 'Detalhes do Log')
@section('page-subtitle', 'Informações completas da atividade')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Cabeçalho -->
    <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detalhes da Atividade</h1>
                <p class="text-gray-600">{{ $activityLog->formatted_description }}</p>
            </div>
            <div class="flex items-center gap-2">
                @php
                    $actionColors = [
                        'created' => 'bg-green-100 text-green-800',
                        'updated' => 'bg-blue-100 text-blue-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        'confirmed' => 'bg-blue-100 text-blue-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'no_show' => 'bg-orange-100 text-orange-800',
                        'rescheduled' => 'bg-yellow-100 text-yellow-800',
                        'deleted' => 'bg-red-100 text-red-800',
                        'payment_received' => 'bg-green-100 text-green-800',
                        'feedback_sent' => 'bg-purple-100 text-purple-800',
                    ];
                    $colorClass = $actionColors[$activityLog->action] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $colorClass }}">
                    {{ $activityLog->action_name }}
                </span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-700">Data/Hora:</span>
                <span class="text-gray-900">{{ $activityLog->created_at->format('d/m/Y H:i:s') }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700">Entidade:</span>
                <span class="text-gray-900">{{ $activityLog->entity_name }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700">IP:</span>
                <span class="text-gray-900">{{ $activityLog->ip_address ?? 'Não informado' }}</span>
            </div>
        </div>
    </div>

    <!-- Informações do Agendamento -->
    @if($activityLog->appointment)
        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Informações do Agendamento
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-medium text-gray-700 mb-2">Cliente</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($activityLog->appointment->customer->name ?? 'C', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $activityLog->appointment->customer->name }}</p>
                            <p class="text-sm text-gray-500">{{ $activityLog->appointment->customer->phone }}</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-medium text-gray-700 mb-2">Serviço</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $activityLog->appointment->service->name }}</p>
                            <p class="text-sm text-gray-500">{{ $activityLog->appointment->service->duration }} minutos</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-medium text-gray-700 mb-2">Data/Hora</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($activityLog->appointment->start_time)->format('d/m/Y') }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($activityLog->appointment->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($activityLog->appointment->end_time)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-medium text-gray-700 mb-2">Status</h3>
                    <div class="flex items-center gap-3">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'confirmed' => 'bg-blue-100 text-blue-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'no-show' => 'bg-orange-100 text-orange-800',
                            ];
                            $statusLabels = [
                                'pending' => 'Pendente',
                                'confirmed' => 'Confirmado',
                                'cancelled' => 'Cancelado',
                                'completed' => 'Concluído',
                                'no-show' => 'Não Compareceu',
                            ];
                            $statusColor = $statusColors[$activityLog->appointment->status] ?? 'bg-gray-100 text-gray-800';
                            $statusLabel = $statusLabels[$activityLog->appointment->status] ?? $activityLog->appointment->status;
                        @endphp
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Alterações (se houver) -->
    @if($activityLog->old_values || $activityLog->new_values)
        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Alterações Realizadas
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @if($activityLog->old_values)
                    <div>
                        <h3 class="font-medium text-gray-700 mb-3 text-red-600">Valores Anteriores</h3>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <pre class="text-sm text-gray-800 whitespace-pre-wrap">{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                @endif
                
                @if($activityLog->new_values)
                    <div>
                        <h3 class="font-medium text-gray-700 mb-3 text-green-600">Novos Valores</h3>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <pre class="text-sm text-gray-800 whitespace-pre-wrap">{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Informações Técnicas -->
    <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Informações Técnicas
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-medium text-gray-700 mb-2">Usuário Responsável</h3>
                <p class="text-gray-900">{{ $activityLog->user->name ?? 'Sistema' }}</p>
            </div>
            
            <div>
                <h3 class="font-medium text-gray-700 mb-2">ID da Entidade</h3>
                <p class="text-gray-900">{{ $activityLog->entity_id ?? 'N/A' }}</p>
            </div>
            
            @if($activityLog->user_agent)
                <div class="md:col-span-2">
                    <h3 class="font-medium text-gray-700 mb-2">User Agent</h3>
                    <p class="text-sm text-gray-600 break-all">{{ $activityLog->user_agent }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Ações -->
    <div class="flex justify-between items-center">
        <a href="{{ route('panel.activity-logs.index') }}" 
           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
            ← Voltar para Lista
        </a>
        
        @if($activityLog->appointment)
            <a href="{{ route('panel.agenda.edit', $activityLog->appointment->id) }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                ✏️ Editar Agendamento
            </a>
        @endif
    </div>
</div>

@endsection
