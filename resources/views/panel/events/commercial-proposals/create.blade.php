@extends('panel.layout')

@section('title', 'Nova Proposta Comercial')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Nova Proposta Comercial</h1>
            <p class="text-gray-600">Crie uma proposta comercial para o evento: {{ $event->title }}</p>
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
        <form method="POST" action="{{ route('panel.events.commercial-proposals.store', $event) }}" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data da Proposta -->
                <div>
                    <label for="proposal_date" class="block text-sm font-medium text-gray-700 mb-2">Data da Proposta *</label>
                    <input type="date" id="proposal_date" name="proposal_date" value="{{ old('proposal_date', now()->format('Y-m-d')) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('proposal_date') border-red-500 @enderror" 
                           required>
                    @error('proposal_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Válida Até -->
                <div>
                    <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-2">Válida Até *</label>
                    <input type="date" id="valid_until" name="valid_until" value="{{ old('valid_until', now()->addDays(30)->format('Y-m-d')) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('valid_until') border-red-500 @enderror" 
                           required>
                    @error('valid_until')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Resumo Executivo -->
            <div>
                <label for="executive_summary" class="block text-sm font-medium text-gray-700 mb-2">Resumo Executivo *</label>
                <textarea id="executive_summary" name="executive_summary" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('executive_summary') border-red-500 @enderror" 
                          placeholder="Resumo executivo da proposta..." required>{{ old('executive_summary') }}</textarea>
                @error('executive_summary')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descrição do Evento -->
            <div>
                <label for="event_description" class="block text-sm font-medium text-gray-700 mb-2">Descrição do Evento *</label>
                <textarea id="event_description" name="event_description" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('event_description') border-red-500 @enderror" 
                          placeholder="Descreva o evento..." required>{{ old('event_description') }}</textarea>
                @error('event_description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Serviços Oferecidos -->
            <div>
                <label for="services_offered" class="block text-sm font-medium text-gray-700 mb-2">Serviços Oferecidos *</label>
                <textarea id="services_offered" name="services_offered" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('services_offered') border-red-500 @enderror" 
                          placeholder="Liste os serviços oferecidos..." required>{{ old('services_offered') }}</textarea>
                @error('services_offered')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Equipamentos Incluídos -->
            <div>
                <label for="equipment_included" class="block text-sm font-medium text-gray-700 mb-2">Equipamentos Incluídos *</label>
                <textarea id="equipment_included" name="equipment_included" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('equipment_included') border-red-500 @enderror" 
                          placeholder="Liste os equipamentos incluídos..." required>{{ old('equipment_included') }}</textarea>
                @error('equipment_included')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estrutura da Equipe -->
            <div>
                <label for="team_structure" class="block text-sm font-medium text-gray-700 mb-2">Estrutura da Equipe *</label>
                <textarea id="team_structure" name="team_structure" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('team_structure') border-red-500 @enderror" 
                          placeholder="Descreva a estrutura da equipe..." required>{{ old('team_structure') }}</textarea>
                @error('team_structure')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cronograma -->
            <div>
                <label for="timeline" class="block text-sm font-medium text-gray-700 mb-2">Cronograma *</label>
                <textarea id="timeline" name="timeline" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('timeline') border-red-500 @enderror" 
                          placeholder="Descreva o cronograma..." required>{{ old('timeline') }}</textarea>
                @error('timeline')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Entregáveis -->
            <div>
                <label for="deliverables" class="block text-sm font-medium text-gray-700 mb-2">Entregáveis *</label>
                <textarea id="deliverables" name="deliverables" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('deliverables') border-red-500 @enderror" 
                          placeholder="Liste os entregáveis..." required>{{ old('deliverables') }}</textarea>
                @error('deliverables')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Valor Total -->
                <div>
                    <label for="total_value" class="block text-sm font-medium text-gray-700 mb-2">Valor Total *</label>
                    <input type="number" id="total_value" name="total_value" value="{{ old('total_value', $event->final_value) }}" step="0.01" min="0.01" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('total_value') border-red-500 @enderror" 
                           placeholder="0,00" required>
                    @error('total_value')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Percentual de Desconto -->
                <div>
                    <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">Desconto (%)</label>
                    <input type="number" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage') }}" step="0.01" min="0" max="100" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('discount_percentage') border-red-500 @enderror" 
                           placeholder="0,00">
                    @error('discount_percentage')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Valor do Desconto -->
                <div>
                    <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-2">Valor do Desconto</label>
                    <input type="number" id="discount_value" name="discount_value" value="{{ old('discount_value') }}" step="0.01" min="0" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('discount_value') border-red-500 @enderror" 
                           placeholder="0,00">
                    @error('discount_value')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Termos e Condições -->
            <div>
                <label for="terms_and_conditions" class="block text-sm font-medium text-gray-700 mb-2">Termos e Condições *</label>
                <textarea id="terms_and_conditions" name="terms_and_conditions" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('terms_and_conditions') border-red-500 @enderror" 
                          placeholder="Descreva os termos e condições..." required>{{ old('terms_and_conditions') }}</textarea>
                @error('terms_and_conditions')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cronograma de Pagamento -->
            <div>
                <label for="payment_schedule" class="block text-sm font-medium text-gray-700 mb-2">Cronograma de Pagamento *</label>
                <textarea id="payment_schedule" name="payment_schedule" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_schedule') border-red-500 @enderror" 
                          placeholder="Descreva o cronograma de pagamento..." required>{{ old('payment_schedule') }}</textarea>
                @error('payment_schedule')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Observações -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
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
                    Criar Proposta
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
