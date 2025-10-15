@extends('panel.layout')

@section('title', 'Nova Nota de Serviço')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Nova Nota de Serviço</h1>
            <p class="text-gray-600">Crie uma nota de serviço para o evento: {{ $event->title }}</p>
        </div>
        <a href="{{ route('panel.events.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            Voltar
        </a>
    </div>

    <!-- Event Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-blue-800">Informações do Evento</h3>
                <p class="text-sm text-blue-600">
                    <strong>Cliente:</strong> {{ $event->customer->name }} | 
                    <strong>Data:</strong> {{ $event->event_date->format('d/m/Y') }} | 
                    <strong>Tipo:</strong> {{ ucfirst($event->event_type) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('panel.events.service-notes.store', $event) }}" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data da Nota -->
                <div>
                    <label for="note_date" class="block text-sm font-medium text-gray-700 mb-2">Data da Nota *</label>
                    <input type="date" id="note_date" name="note_date" value="{{ old('note_date', now()->format('Y-m-d')) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('note_date') border-red-500 @enderror" 
                           required>
                    @error('note_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ordem de Serviço -->
                <div>
                    <label for="service_order_id" class="block text-sm font-medium text-gray-700 mb-2">Ordem de Serviço</label>
                    <select id="service_order_id" name="service_order_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('service_order_id') border-red-500 @enderror">
                        <option value="">Selecione uma ordem de serviço (opcional)</option>
                        @foreach($serviceOrders as $serviceOrder)
                            <option value="{{ $serviceOrder->id }}" {{ old('service_order_id') == $serviceOrder->id ? 'selected' : '' }}>
                                {{ $serviceOrder->order_number }} - {{ $serviceOrder->status }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_order_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Descrição -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição dos Serviços *</label>
                <textarea id="description" name="description" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror" 
                          placeholder="Descreva os serviços prestados..." required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Equipamentos Utilizados -->
            <div>
                <label for="equipment_used" class="block text-sm font-medium text-gray-700 mb-2">Equipamentos Utilizados *</label>
                <textarea id="equipment_used" name="equipment_used" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('equipment_used') border-red-500 @enderror" 
                          placeholder="Liste os equipamentos utilizados..." required>{{ old('equipment_used') }}</textarea>
                @error('equipment_used')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Horas Trabalhadas -->
            <div>
                <label for="hours_worked" class="block text-sm font-medium text-gray-700 mb-2">Horas Trabalhadas *</label>
                <textarea id="hours_worked" name="hours_worked" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('hours_worked') border-red-500 @enderror" 
                          placeholder="Descreva as horas trabalhadas por equipamento/funcionário..." required>{{ old('hours_worked') }}</textarea>
                @error('hours_worked')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Membros da Equipe -->
            <div>
                <label for="team_members" class="block text-sm font-medium text-gray-700 mb-2">Membros da Equipe *</label>
                <textarea id="team_members" name="team_members" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('team_members') border-red-500 @enderror" 
                          placeholder="Liste os membros da equipe que trabalharam..." required>{{ old('team_members') }}</textarea>
                @error('team_members')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Total de Horas -->
                <div>
                    <label for="total_hours" class="block text-sm font-medium text-gray-700 mb-2">Total de Horas *</label>
                    <input type="number" id="total_hours" name="total_hours" value="{{ old('total_hours') }}" step="0.5" min="0.5" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('total_hours') border-red-500 @enderror" 
                           placeholder="0,0" required>
                    @error('total_hours')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Taxa por Hora -->
                <div>
                    <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">Taxa por Hora *</label>
                    <input type="number" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate') }}" step="0.01" min="0.01" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('hourly_rate') border-red-500 @enderror" 
                           placeholder="0,00" required>
                    @error('hourly_rate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Observações -->
            <div>
                <label for="observations" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                <textarea id="observations" name="observations" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('observations') border-red-500 @enderror" 
                          placeholder="Observações sobre o serviço prestado...">{{ old('observations') }}</textarea>
                @error('observations')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Problemas Encontrados -->
            <div>
                <label for="issues_encountered" class="block text-sm font-medium text-gray-700 mb-2">Problemas Encontrados</label>
                <textarea id="issues_encountered" name="issues_encountered" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('issues_encountered') border-red-500 @enderror" 
                          placeholder="Descreva problemas encontrados durante o serviço...">{{ old('issues_encountered') }}</textarea>
                @error('issues_encountered')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Soluções Aplicadas -->
            <div>
                <label for="solutions_applied" class="block text-sm font-medium text-gray-700 mb-2">Soluções Aplicadas</label>
                <textarea id="solutions_applied" name="solutions_applied" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('solutions_applied') border-red-500 @enderror" 
                          placeholder="Descreva as soluções aplicadas...">{{ old('solutions_applied') }}</textarea>
                @error('solutions_applied')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Feedback do Cliente -->
            <div>
                <label for="client_feedback" class="block text-sm font-medium text-gray-700 mb-2">Feedback do Cliente</label>
                <textarea id="client_feedback" name="client_feedback" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('client_feedback') border-red-500 @enderror" 
                          placeholder="Feedback recebido do cliente...">{{ old('client_feedback') }}</textarea>
                @error('client_feedback')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Observações Adicionais -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações Adicionais</label>
                <textarea id="notes" name="notes" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror" 
                          placeholder="Observações adicionais...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('panel.events.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    Criar Nota de Serviço
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
