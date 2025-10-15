@extends('panel.layout')

@section('title', 'Editar Contrato - ' . $contract->contract_number)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Editar Contrato</h1>
            <p class="text-gray-600">Contrato: {{ $contract->contract_number }} - Evento: {{ $contract->event->title }}</p>
        </div>
        <a href="{{ route('panel.events.contracts.show', $contract) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            Voltar
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('panel.events.contracts.update', $contract) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Hidden status field -->
            <input type="hidden" name="status" value="{{ $contract->status }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data do Contrato -->
                <div>
                    <label for="contract_date" class="block text-sm font-medium text-gray-700 mb-2">Data do Contrato *</label>
                    <input type="date" id="contract_date" name="contract_date" value="{{ old('contract_date', $contract->contract_date->format('Y-m-d')) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('contract_date') border-red-500 @enderror" 
                           required>
                    @error('contract_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Orçamento -->
                <div>
                    <label for="budget_id" class="block text-sm font-medium text-gray-700 mb-2">Orçamento</label>
                    <select id="budget_id" name="budget_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('budget_id') border-red-500 @enderror">
                        <option value="">Selecione um orçamento (opcional)</option>
                        @foreach($budgets as $budget)
                            <option value="{{ $budget->id }}" {{ old('budget_id', $contract->budget_id) == $budget->id ? 'selected' : '' }}>
                                {{ $budget->budget_number }} - R$ {{ number_format($budget->total, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('budget_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data de Início -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Data de Início *</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $contract->start_date->format('Y-m-d')) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('start_date') border-red-500 @enderror" 
                           required>
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data de Término -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Data de Término *</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $contract->end_date->format('Y-m-d')) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('end_date') border-red-500 @enderror" 
                           required>
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Valor Total -->
                <div>
                    <label for="total_value" class="block text-sm font-medium text-gray-700 mb-2">Valor Total *</label>
                    <input type="number" id="total_value" name="total_value" value="{{ old('total_value', $contract->total_value) }}" step="0.01" min="0.01" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('total_value') border-red-500 @enderror" 
                           placeholder="0,00" required>
                    @error('total_value')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pagamento Antecipado -->
                <div>
                    <label for="advance_payment" class="block text-sm font-medium text-gray-700 mb-2">Pagamento Antecipado</label>
                    <input type="number" id="advance_payment" name="advance_payment" value="{{ old('advance_payment', $contract->advance_payment) }}" step="0.01" min="0" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('advance_payment') border-red-500 @enderror" 
                           placeholder="0,00">
                    @error('advance_payment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pagamento Final -->
                <div>
                    <label for="final_payment" class="block text-sm font-medium text-gray-700 mb-2">Pagamento Final</label>
                    <input type="number" id="final_payment" name="final_payment" value="{{ old('final_payment', $contract->final_payment) }}" step="0.01" min="0" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('final_payment') border-red-500 @enderror" 
                           placeholder="0,00">
                    @error('final_payment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Termos e Condições -->
            <div>
                <label for="terms_and_conditions" class="block text-sm font-medium text-gray-700 mb-2">Termos e Condições *</label>
                <textarea id="terms_and_conditions" name="terms_and_conditions" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('terms_and_conditions') border-red-500 @enderror" 
                          placeholder="Descreva os termos e condições do contrato..." required>{{ old('terms_and_conditions', $contract->terms_and_conditions) }}</textarea>
                @error('terms_and_conditions')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Termos de Pagamento -->
            <div>
                <label for="payment_terms" class="block text-sm font-medium text-gray-700 mb-2">Termos de Pagamento *</label>
                <textarea id="payment_terms" name="payment_terms" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_terms') border-red-500 @enderror" 
                          placeholder="Descreva as condições de pagamento..." required>{{ old('payment_terms', $contract->payment_terms) }}</textarea>
                @error('payment_terms')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Política de Cancelamento -->
            <div>
                <label for="cancellation_policy" class="block text-sm font-medium text-gray-700 mb-2">Política de Cancelamento *</label>
                <textarea id="cancellation_policy" name="cancellation_policy" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('cancellation_policy') border-red-500 @enderror" 
                          placeholder="Descreva a política de cancelamento..." required>{{ old('cancellation_policy', $contract->cancellation_policy) }}</textarea>
                @error('cancellation_policy')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Termos de Responsabilidade -->
            <div>
                <label for="liability_terms" class="block text-sm font-medium text-gray-700 mb-2">Termos de Responsabilidade *</label>
                <textarea id="liability_terms" name="liability_terms" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('liability_terms') border-red-500 @enderror" 
                          placeholder="Descreva os termos de responsabilidade..." required>{{ old('liability_terms', $contract->liability_terms) }}</textarea>
                @error('liability_terms')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Observações -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                <textarea id="notes" name="notes" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror" 
                          placeholder="Observações adicionais...">{{ old('notes', $contract->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('panel.events.contracts.show', $contract) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
