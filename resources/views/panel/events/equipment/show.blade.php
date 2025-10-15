@extends('panel.layout')

@section('page-title', $equipment->name)
@section('page-subtitle', 'Detalhes do equipamento')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('panel.events.equipment.edit', $equipment) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Editar</span>
        </a>
        <a href="{{ route('panel.events.equipment.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Voltar</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informações Principais -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Dados do Equipamento -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $equipment->name }}</h1>
                            <div class="flex items-center space-x-4 mt-1">
                                <span class="text-lg font-semibold text-green-600">R$ {{ number_format($equipment->hourly_rate, 2, ',', '.') }}/hora</span>
                                @if($equipment->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ativo</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inativo</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($equipment->description)
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Descrição</h3>
                        <p class="text-gray-900">{{ $equipment->description }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Valor por Hora</h3>
                        <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($equipment->hourly_rate, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Horas Mínimas</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $equipment->minimum_hours }} horas</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Usado em Eventos</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $equipment->services->count() }} vezes</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Faturamento Total</h3>
                        <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($equipment->services->sum('total_value'), 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Especificações Técnicas -->
            @if($equipment->technical_specs)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Especificações Técnicas</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-900 whitespace-pre-line">{{ $equipment->technical_specs }}</p>
                    </div>
                </div>
            @endif

            <!-- Requisitos de Montagem -->
            @if($equipment->setup_requirements)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Requisitos de Montagem</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-900 whitespace-pre-line">{{ $equipment->setup_requirements }}</p>
                    </div>
                </div>
            @endif

            <!-- Histórico de Uso -->
            @if($equipment->services->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Histórico de Uso</h3>
                    
                    <div class="space-y-4">
                        @foreach($equipment->services as $service)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $service->event->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $service->event->customer->name }} • {{ $service->event->event_date->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">{{ $service->hours }}h × R$ {{ number_format($service->hourly_rate, 2, ',', '.') }}</p>
                                        <p class="text-sm font-medium text-green-600">R$ {{ number_format($service->total_value, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                                @if($service->notes)
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-500">{{ $service->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Estatísticas -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Estatísticas</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Total de Eventos:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $equipment->services->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Horas Totais:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $equipment->services->sum('hours') }}h</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Faturamento:</span>
                        <span class="text-sm font-medium text-gray-900">R$ {{ number_format($equipment->services->sum('total_value'), 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Média por Evento:</span>
                        <span class="text-sm font-medium text-gray-900">
                            @if($equipment->services->count() > 0)
                                R$ {{ number_format($equipment->services->sum('total_value') / $equipment->services->count(), 2, ',', '.') }}
                            @else
                                R$ 0,00
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ações</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('panel.events.equipment.edit', $equipment) }}" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-center block">
                        Editar Equipamento
                    </a>
                    
                    <form action="{{ route('panel.events.equipment.toggle-status', $equipment) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-{{ $equipment->is_active ? 'yellow' : 'green' }}-600 text-white rounded-lg hover:bg-{{ $equipment->is_active ? 'yellow' : 'green' }}-700 transition">
                            {{ $equipment->is_active ? 'Desativar' : 'Ativar' }} Equipamento
                        </button>
                    </form>
                    
                    @if($equipment->services->count() == 0)
                        <form action="{{ route('panel.events.equipment.destroy', $equipment) }}" method="POST" class="w-full" onsubmit="return confirm('Tem certeza que deseja remover este equipamento?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Remover Equipamento
                            </button>
                        </form>
                    @else
                        <div class="text-center py-2">
                            <p class="text-xs text-gray-500">Não é possível remover equipamento em uso</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informações Adicionais -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações</h3>
                
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500">Criado em:</span>
                        <span class="text-gray-900">{{ $equipment->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Última atualização:</span>
                        <span class="text-gray-900">{{ $equipment->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
