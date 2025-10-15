@extends('panel.layout')

@section('page-title', $event->title)
@section('page-subtitle', 'Detalhes do evento')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('panel.events.edit', $event) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Editar</span>
        </a>
        @if($event->services->count() > 0)
            <a href="{{ route('panel.events.budgets.create', $event) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Criar Orçamento</span>
            </a>
        @endif
        <a href="{{ route('panel.events.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition inline-flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Voltar</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informações Principais -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Dados do Evento -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Informações do Evento</h3>
                    @switch($event->status)
                        @case('orcamento')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Orçamento</span>
                            @break
                        @case('confirmado')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Confirmado</span>
                            @break
                        @case('em_andamento')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">Em Andamento</span>
                            @break
                        @case('concluido')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">Concluído</span>
                            @break
                        @case('cancelado')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Cancelado</span>
                            @break
                    @endswitch
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Cliente</h4>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-xs">{{ substr($event->customer->name, 0, 2) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $event->customer->name }}</p>
                                <p class="text-xs text-gray-500">{{ $event->customer->phone ?? 'Sem telefone' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Tipo de Evento</h4>
                        <p class="text-sm text-gray-900">{{ ucfirst($event->type) }}</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Data e Horário</h4>
                        <p class="text-sm text-gray-900">{{ $event->event_date->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-900">{{ $event->start_time }} - {{ $event->end_time }}</p>
                        <p class="text-xs text-gray-500">Duração: {{ $event->duration }} horas</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Local</h4>
                        <p class="text-sm text-gray-900">{{ $event->address }}</p>
                        <p class="text-sm text-gray-900">{{ $event->city }}/{{ $event->state }}</p>
                        @if($event->zip_code)
                            <p class="text-xs text-gray-500">CEP: {{ $event->zip_code }}</p>
                        @endif
                    </div>
                </div>

                @if($event->description)
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Descrição</h4>
                        <p class="text-sm text-gray-900">{{ $event->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Equipamentos Contratados -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Equipamentos Contratados</h3>
                    <button onclick="openAddServiceModal()" class="px-3 py-1 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm">
                        Adicionar Equipamento
                    </button>
                </div>

                @if($event->services->count() > 0)
                    <div class="space-y-4">
                        @foreach($event->services as $service)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $service->equipment->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $service->hours }}h × R$ {{ number_format($service->hourly_rate, 2, ',', '.') }}/h</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-gray-900">R$ {{ number_format($service->total_value, 2, ',', '.') }}</p>
                                        </div>
                                        <form action="{{ route('panel.events.remove-service', $service) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 transition" onclick="return confirm('Tem certeza que deseja remover este equipamento?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
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
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Nenhum equipamento contratado</h4>
                        <p class="text-sm text-gray-500 mb-4">Adicione equipamentos para este evento.</p>
                        <button onclick="openAddServiceModal()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Adicionar Equipamento
                        </button>
                    </div>
                @endif
            </div>

            <!-- Funcionários -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Funcionários</h3>
                    <button onclick="openAddEmployeeModal()" class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                        Adicionar Funcionário
                    </button>
                </div>

                @if($event->employees->count() > 0)
                    <div class="space-y-4">
                        @foreach($event->employees as $employee)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-blue-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">{{ substr($employee->name, 0, 2) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $employee->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $employee->role }} • {{ $employee->hours }}h × R$ {{ number_format($employee->hourly_rate, 2, ',', '.') }}/h</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-gray-900">R$ {{ number_format($employee->total_value, 2, ',', '.') }}</p>
                                        </div>
                                        <form action="{{ route('panel.events.remove-employee', $employee) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 transition" onclick="return confirm('Tem certeza que deseja remover este funcionário?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @if($employee->notes)
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-500">{{ $employee->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Nenhum funcionário adicionado</h4>
                        <p class="text-sm text-gray-500 mb-4">Adicione funcionários para este evento.</p>
                        <button onclick="openAddEmployeeModal()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Adicionar Funcionário
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Resumo Financeiro -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumo Financeiro</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Equipamentos:</span>
                        <span class="text-sm font-medium text-gray-900">R$ {{ number_format($event->total_equipment_value, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Funcionários:</span>
                        <span class="text-sm font-medium text-gray-900">R$ {{ number_format($event->total_employee_value, 2, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-900">Subtotal:</span>
                            <span class="text-sm font-medium text-gray-900">R$ {{ number_format($event->total_value, 2, ',', '.') }}</span>
                        </div>
                        @if($event->discount > 0)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Desconto:</span>
                                <span class="text-sm text-red-600">-R$ {{ number_format($event->discount, 2, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between mt-2">
                            <span class="text-base font-semibold text-gray-900">Total:</span>
                            <span class="text-base font-semibold text-gray-900">R$ {{ number_format($event->final_value, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orçamentos -->
            @if($event->budgets->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Orçamentos</h3>
                    
                    <div class="space-y-3">
                        @foreach($event->budgets as $budget)
                            <div class="border border-gray-200 rounded-lg p-3">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm font-medium text-gray-900">{{ $budget->budget_number }}</p>
                                    @switch($budget->status)
                                        @case('rascunho')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Rascunho</span>
                                            @break
                                        @case('enviado')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Enviado</span>
                                            @break
                                        @case('aprovado')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Aprovado</span>
                                            @break
                                        @case('rejeitado')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejeitado</span>
                                            @break
                                    @endswitch
                                </div>
                                <p class="text-sm text-gray-600">R$ {{ number_format($budget->total, 2, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">Válido até: {{ $budget->valid_until->format('d/m/Y') }}</p>
                                <div class="mt-2 flex space-x-2">
                                    <a href="{{ route('panel.events.budgets.show', $budget) }}" class="text-xs text-blue-600 hover:text-blue-800">Ver</a>
                                    <a href="{{ route('panel.events.budgets.pdf', $budget) }}" class="text-xs text-green-600 hover:text-green-800">PDF</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Observações -->
            @if($event->notes || $event->equipment_notes || $event->setup_notes)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Observações</h3>
                    
                    <div class="space-y-4">
                        @if($event->notes)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Gerais</h4>
                                <p class="text-sm text-gray-900">{{ $event->notes }}</p>
                            </div>
                        @endif
                        
                        @if($event->equipment_notes)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Equipamentos</h4>
                                <p class="text-sm text-gray-900">{{ $event->equipment_notes }}</p>
                            </div>
                        @endif
                        
                        @if($event->setup_notes)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Montagem</h4>
                                <p class="text-sm text-gray-900">{{ $event->setup_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para Adicionar Equipamento -->
<div id="addServiceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <form action="{{ route('panel.events.add-service', $event) }}" method="POST">
                @csrf
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Adicionar Equipamento</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="equipment_id" class="block text-sm font-medium text-gray-700 mb-2">Equipamento *</label>
                            <select id="equipment_id" name="equipment_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                <option value="">Selecione um equipamento</option>
                                @foreach($equipment as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} - R$ {{ number_format($item->hourly_rate, 2, ',', '.') }}/h</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="hours" class="block text-sm font-medium text-gray-700 mb-2">Horas *</label>
                            <input type="number" id="hours" name="hours" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                            <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 px-6 py-4 bg-gray-50 rounded-b-lg">
                    <button type="button" onclick="closeAddServiceModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                        Adicionar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Adicionar Funcionário -->
<div id="addEmployeeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <form action="{{ route('panel.events.add-employee', $event) }}" method="POST">
                @csrf
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Adicionar Funcionário</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                            <input type="text" id="name" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                                <input type="text" id="phone" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Função *</label>
                            <input type="text" id="role" name="role" placeholder="Ex: Fotógrafo, Operador, Assistente" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">Valor/Hora *</label>
                                <input type="number" id="hourly_rate" name="hourly_rate" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label for="hours" class="block text-sm font-medium text-gray-700 mb-2">Horas *</label>
                                <input type="number" id="hours" name="hours" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            </div>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                            <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 px-6 py-4 bg-gray-50 rounded-b-lg">
                    <button type="button" onclick="closeAddEmployeeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                        Adicionar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAddServiceModal() {
    document.getElementById('addServiceModal').classList.remove('hidden');
}

function closeAddServiceModal() {
    document.getElementById('addServiceModal').classList.add('hidden');
}

function openAddEmployeeModal() {
    document.getElementById('addEmployeeModal').classList.remove('hidden');
}

function closeAddEmployeeModal() {
    document.getElementById('addEmployeeModal').classList.add('hidden');
}

// Fechar modais ao clicar fora
document.getElementById('addServiceModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddServiceModal();
    }
});

document.getElementById('addEmployeeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddEmployeeModal();
    }
});
</script>
@endsection
