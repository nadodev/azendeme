@extends('panel.layout')

@section('page-title', 'Novo Evento')
@section('page-subtitle', 'Crie um novo evento para seus clientes')

@section('header-actions')
    <a href="{{ route('panel.events.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition inline-flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Voltar</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <form action="{{ route('panel.events.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Formulário Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informações Básicas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações do Evento</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">Cliente *</label>
                            <select id="customer_id" name="customer_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('customer_id') border-red-500 @enderror" required>
                                <option value="">Selecione um cliente</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Evento *</label>
                            <select id="type" name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('type') border-red-500 @enderror" required>
                                <option value="">Selecione o tipo</option>
                                <option value="formatura" {{ old('type') == 'formatura' ? 'selected' : '' }}>Formatura</option>
                                <option value="aniversario" {{ old('type') == 'aniversario' ? 'selected' : '' }}>Aniversário</option>
                                <option value="casamento" {{ old('type') == 'casamento' ? 'selected' : '' }}>Casamento</option>
                                <option value="carnaval" {{ old('type') == 'carnaval' ? 'selected' : '' }}>Carnaval</option>
                                <option value="corporativo" {{ old('type') == 'corporativo' ? 'selected' : '' }}>Corporativo</option>
                                <option value="outro" {{ old('type') == 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título do Evento *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('title') border-red-500 @enderror" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                        <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Data e Horário -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Data e Horário</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">Data do Evento *</label>
                            <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('event_date') border-red-500 @enderror" required>
                            @error('event_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Horário de Início *</label>
                            <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('start_time') border-red-500 @enderror" required>
                            @error('start_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">Horário de Término *</label>
                            <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('end_time') border-red-500 @enderror" required>
                            @error('end_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Local do Evento -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Local do Evento</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Endereço *</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('address') border-red-500 @enderror" required>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Cidade *</label>
                                <input type="text" id="city" name="city" value="{{ old('city') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('city') border-red-500 @enderror" required>
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                                <input type="text" id="state" name="state" value="{{ old('state') }}" maxlength="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('state') border-red-500 @enderror" required>
                                @error('state')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-2">CEP</label>
                                <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('zip_code') border-red-500 @enderror">
                                @error('zip_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status do Evento *</label>
                        <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('status') border-red-500 @enderror" required>
                            <option value="orcamento" {{ old('status', 'orcamento') == 'orcamento' ? 'selected' : '' }}>Orçamento</option>
                            <option value="confirmado" {{ old('status') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                            <option value="em_andamento" {{ old('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                            <option value="concluido" {{ old('status') == 'concluido' ? 'selected' : '' }}>Concluído</option>
                            <option value="cancelado" {{ old('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Observações -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Observações</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações Gerais</label>
                            <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="equipment_notes" class="block text-sm font-medium text-gray-700 mb-2">Observações dos Equipamentos</label>
                            <textarea id="equipment_notes" name="equipment_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('equipment_notes') border-red-500 @enderror">{{ old('equipment_notes') }}</textarea>
                            @error('equipment_notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="setup_notes" class="block text-sm font-medium text-gray-700 mb-2">Observações de Montagem</label>
                            <textarea id="setup_notes" name="setup_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('setup_notes') border-red-500 @enderror">{{ old('setup_notes') }}</textarea>
                            @error('setup_notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Criar Evento
                        </button>
                        <a href="{{ route('panel.events.index') }}" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-center block">
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
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const form = document.querySelector('form');

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
                endTimeInput.setCustomValidity('A duração do evento não pode ser superior a 24 horas.');
            } else if (duration < 1) {
                endTimeInput.setCustomValidity('A duração do evento deve ser de pelo menos 1 hora.');
            } else {
                endTimeInput.setCustomValidity('');
            }
        }
    }

    startTimeInput.addEventListener('change', validateTimes);
    endTimeInput.addEventListener('change', validateTimes);

    // Adicionar dica visual para eventos que passam da meia-noite
    function updateTimeHint() {
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;
        
        if (startTime && endTime) {
            const start = new Date('2000-01-01 ' + startTime);
            const end = new Date('2000-01-01 ' + endTime);
            
            if (end < start) {
                // Evento passa da meia-noite
                let hint = document.getElementById('time-hint');
                if (!hint) {
                    hint = document.createElement('div');
                    hint.id = 'time-hint';
                    hint.className = 'text-xs text-blue-600 mt-1';
                    endTimeInput.parentNode.appendChild(hint);
                }
                hint.textContent = 'Evento termina no dia seguinte';
            } else {
                const hint = document.getElementById('time-hint');
                if (hint) {
                    hint.remove();
                }
            }
        }
    }

    startTimeInput.addEventListener('change', updateTimeHint);
    endTimeInput.addEventListener('change', updateTimeHint);
});
</script>
@endsection
