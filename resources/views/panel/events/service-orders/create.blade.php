@extends('panel.layout')

@section('page-title', 'Criar Ordem de Serviço')
@section('page-subtitle', 'Crie uma nova ordem de serviço para o evento')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('panel.events.service-orders.store', $event) }}" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informações do Evento -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Evento</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cliente</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                {{ $event->customer->name }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Evento</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                {{ $event->title }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                {{ ucfirst($event->type) }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data Original</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                {{ $event->event_date->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agendamento da OS -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Agendamento da OS</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="scheduled_date" class="block text-sm font-medium text-gray-700 mb-2">Data Agendada *</label>
                            <input type="date" id="scheduled_date" name="scheduled_date" 
                                   value="{{ $event->event_date->toDateString() }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="scheduled_start_time" class="block text-sm font-medium text-gray-700 mb-2">Horário de Início *</label>
                                <input type="time" id="scheduled_start_time" name="scheduled_start_time" 
                                       value="{{ $event->start_time->format('H:i') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            </div>
                            
                            <div>
                                <label for="scheduled_end_time" class="block text-sm font-medium text-gray-700 mb-2">Horário de Término *</label>
                                <input type="time" id="scheduled_end_time" name="scheduled_end_time" 
                                       value="{{ $event->end_time->format('H:i') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalhes da OS -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Detalhes da OS</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição dos Serviços</label>
                            <textarea id="description" name="description" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Descreva os serviços que serão executados...">{{ $budget ? 'Ordem de Serviço baseada no orçamento aprovado.' : '' }}</textarea>
                        </div>
                        
                        <div>
                            <label for="equipment_list" class="block text-sm font-medium text-gray-700 mb-2">Lista de Equipamentos</label>
                            <textarea id="equipment_list" name="equipment_list" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Liste os equipamentos necessários...">{{ $budget ? $event->services->map(function($service) { return $service->equipment->name . ' - ' . $service->hours . 'h'; })->join(', ') : '' }}</textarea>
                        </div>
                        
                        <div>
                            <label for="employee_assignments" class="block text-sm font-medium text-gray-700 mb-2">Atribuições de Funcionários</label>
                            <textarea id="employee_assignments" name="employee_assignments" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Defina as atribuições dos funcionários...">{{ $budget ? $event->employees->map(function($employee) { return $employee->name . ' (' . $employee->role . ') - ' . $employee->hours . 'h'; })->join(', ') : '' }}</textarea>
                        </div>
                        
                        <div>
                            <label for="setup_instructions" class="block text-sm font-medium text-gray-700 mb-2">Instruções de Montagem</label>
                            <textarea id="setup_instructions" name="setup_instructions" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Instruções específicas para montagem...">{{ $event->setup_notes }}</textarea>
                        </div>
                        
                        <div>
                            <label for="special_requirements" class="block text-sm font-medium text-gray-700 mb-2">Requisitos Especiais</label>
                            <textarea id="special_requirements" name="special_requirements" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Requisitos especiais ou observações...">{{ $event->equipment_notes }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumo -->
            <div class="space-y-6">
                <!-- Informações do Orçamento -->
                @if($budget)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Orçamento Base</h3>
                        
                        <div class="space-y-2 text-sm">
                            <div>
                                <span class="font-medium">Número:</span>
                                <span class="text-gray-600">{{ $budget->budget_number }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Status:</span>
                                <span class="text-gray-600">{{ ucfirst($budget->status) }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Valor:</span>
                                <span class="text-gray-600">R$ {{ number_format($budget->total, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Valor da OS -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Valor da OS</h3>
                    
                    <div>
                        <label for="total_value" class="block text-sm font-medium text-gray-700 mb-2">Valor Total *</label>
                        <input type="number" id="total_value" name="total_value" step="0.01" min="0" 
                               value="{{ $budget ? $budget->total : $event->total_value }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    </div>
                </div>

                <!-- Ações -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Criar Ordem de Serviço
                        </button>
                        <a href="{{ route('panel.events.show', $event) }}" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-center block">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startTimeInput = document.getElementById('scheduled_start_time');
    const endTimeInput = document.getElementById('scheduled_end_time');

    function validateTimes() {
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;
        
        if (startTime && endTime) {
            const start = new Date('2000-01-01 ' + startTime);
            const end = new Date('2000-01-01 ' + endTime);
            
            // Se o horário de término for menor que o de início, assumimos que é no dia seguinte
            if (end < start) {
                end.setDate(end.getDate() + 1);
            }
            
            const duration = (end - start) / (1000 * 60 * 60); // em horas
            
            if (duration > 24) {
                endTimeInput.setCustomValidity('A duração da OS não pode ser superior a 24 horas.');
            } else if (duration < 1) {
                endTimeInput.setCustomValidity('A duração da OS deve ser de pelo menos 1 hora.');
            } else {
                endTimeInput.setCustomValidity('');
            }
        }
    }

    function updateTimeHint() {
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;
        
        if (startTime && endTime) {
            const start = new Date('2000-01-01 ' + startTime);
            const end = new Date('2000-01-01 ' + endTime);
            
            if (end < start) {
                let hint = document.getElementById('time-hint');
                if (!hint) {
                    hint = document.createElement('div');
                    hint.id = 'time-hint';
                    hint.className = 'text-xs text-blue-600 mt-1';
                    endTimeInput.parentNode.appendChild(hint);
                }
                hint.textContent = 'OS termina no dia seguinte';
            } else {
                const hint = document.getElementById('time-hint');
                if (hint) {
                    hint.remove();
                }
            }
        }
    }

    startTimeInput.addEventListener('change', validateTimes);
    endTimeInput.addEventListener('change', validateTimes);
    startTimeInput.addEventListener('change', updateTimeHint);
    endTimeInput.addEventListener('change', updateTimeHint);
});
</script>
@endsection