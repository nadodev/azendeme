@extends('panel.layout')

@section('page-title', 'Editar Orçamento')
@section('page-subtitle', 'Edite as informações do orçamento')

@section('header-actions')
    <a href="{{ route('panel.events.budgets.show', $budget) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition inline-flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Voltar</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <form action="{{ route('panel.events.budgets.update', $budget) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Formulário Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Observações -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Observações do Orçamento</h3>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                        <textarea id="notes" name="notes" rows="4" placeholder="Adicione observações específicas para este orçamento..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes', $budget->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Termos e Condições -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Termos e Condições</h3>
                    
                    <div>
                        <label for="terms" class="block text-sm font-medium text-gray-700 mb-2">Termos e Condições</label>
                        <textarea id="terms" name="terms" rows="6" placeholder="Ex: Pagamento à vista com 5% de desconto. Cancelamento até 48h antes do evento..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('terms') border-red-500 @enderror">{{ old('terms', $budget->terms) }}</textarea>
                        @error('terms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Validade -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Validade do Orçamento</h3>
                    
                    <div>
                        <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-2">Válido até *</label>
                        <input type="date" id="valid_until" name="valid_until" value="{{ old('valid_until', $budget->valid_until->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('valid_until') border-red-500 @enderror" required>
                        @error('valid_until')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Desconto -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Desconto</h3>
                    
                    <div>
                        <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">Desconto (%)</label>
                        <input type="number" id="discount_percentage" name="discount_percentage" step="0.01" min="0" max="100" value="{{ old('discount_percentage', $budget->discount_percentage) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('discount_percentage') border-red-500 @enderror">
                        @error('discount_percentage')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Resumo Financeiro -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumo Financeiro</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Equipamentos:</span>
                            <span class="text-sm font-medium text-gray-900">R$ {{ number_format($budget->equipment_total, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Funcionários:</span>
                            <span class="text-sm font-medium text-gray-900">R$ {{ number_format($budget->employees_total, 2, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-900">Subtotal:</span>
                                <span class="text-sm font-medium text-gray-900">R$ {{ number_format($budget->subtotal, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Desconto:</span>
                                <span class="text-sm text-red-600" id="discount-display">R$ {{ number_format($budget->discount_value, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between mt-2">
                                <span class="text-base font-semibold text-gray-900">Total:</span>
                                <span class="text-base font-semibold text-gray-900" id="total-display">R$ {{ number_format($budget->total, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Salvar Alterações
                        </button>
                        <a href="{{ route('panel.events.budgets.show', $budget) }}" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-center block">
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
    const discountInput = document.getElementById('discount_percentage');
    const discountDisplay = document.getElementById('discount-display');
    const totalDisplay = document.getElementById('total-display');
    const subtotal = {{ $budget->subtotal }};

    function updateTotals() {
        const discountPercentage = parseFloat(discountInput.value) || 0;
        const discountValue = (subtotal * discountPercentage) / 100;
        const total = subtotal - discountValue;

        discountDisplay.textContent = 'R$ ' + discountValue.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        totalDisplay.textContent = 'R$ ' + total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    discountInput.addEventListener('input', updateTotals);
    updateTotals(); // Initial calculation
});
</script>
@endsection
