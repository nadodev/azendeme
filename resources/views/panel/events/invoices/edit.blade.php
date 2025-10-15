@extends('panel.layout')

@section('page-title', 'Editar Fatura ' . $invoice->invoice_number)
@section('page-subtitle', 'Edite os dados da fatura')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('panel.events.invoices.update', $invoice) }}" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informações da Fatura -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações da Fatura</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="invoice_date" class="block text-sm font-medium text-gray-700 mb-2">Data da Fatura *</label>
                            <input type="date" id="invoice_date" name="invoice_date" 
                                   value="{{ $invoice->invoice_date->toDateString() }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Data de Vencimento *</label>
                            <input type="date" id="due_date" name="due_date" 
                                   value="{{ $invoice->due_date->toDateString() }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                <option value="rascunho" {{ $invoice->status === 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                                <option value="enviada" {{ $invoice->status === 'enviada' ? 'selected' : '' }}>Enviada</option>
                                <option value="paga" {{ $invoice->status === 'paga' ? 'selected' : '' }}>Paga</option>
                                <option value="vencida" {{ $invoice->status === 'vencida' ? 'selected' : '' }}>Vencida</option>
                                <option value="cancelada" {{ $invoice->status === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Valores da Fatura -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Valores da Fatura</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="subtotal" class="block text-sm font-medium text-gray-700 mb-2">Subtotal *</label>
                            <input type="number" id="subtotal" name="subtotal" step="0.01" min="0" 
                                   value="{{ $invoice->subtotal }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">Desconto (%)</label>
                                <input type="number" id="discount_percentage" name="discount_percentage" step="0.01" min="0" max="100" 
                                       value="{{ $invoice->discount_percentage }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="tax_percentage" class="block text-sm font-medium text-gray-700 mb-2">Imposto (%)</label>
                                <input type="number" id="tax_percentage" name="tax_percentage" step="0.01" min="0" max="100" 
                                       value="{{ $invoice->tax_percentage }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                            <textarea id="notes" name="notes" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ $invoice->notes }}</textarea>
                        </div>
                        
                        <div>
                            <label for="payment_terms" class="block text-sm font-medium text-gray-700 mb-2">Termos de Pagamento</label>
                            <textarea id="payment_terms" name="payment_terms" rows="2" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ $invoice->payment_terms }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumo -->
            <div class="space-y-6">
                <!-- Informações do Evento -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Evento</h3>
                    
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="font-medium">Cliente:</span>
                            <span class="text-gray-600">{{ $invoice->event->customer->name }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Evento:</span>
                            <span class="text-gray-600">{{ $invoice->event->title }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Data:</span>
                            <span class="text-gray-600">{{ $invoice->event->event_date->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Cálculo Automático -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Resumo Financeiro</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Subtotal:</span>
                            <span class="text-sm font-medium" id="subtotal-display">R$ 0,00</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Desconto:</span>
                            <span class="text-sm font-medium text-red-600" id="discount-display">R$ 0,00</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Imposto:</span>
                            <span class="text-sm font-medium" id="tax-display">R$ 0,00</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-base font-medium text-gray-900">Total:</span>
                                <span class="text-base font-bold text-purple-600" id="total-display">R$ 0,00</span>
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
                        <a href="{{ route('panel.events.invoices.show', $invoice) }}" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-center block">
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
    const subtotalInput = document.getElementById('subtotal');
    const discountInput = document.getElementById('discount_percentage');
    const taxInput = document.getElementById('tax_percentage');
    
    const subtotalDisplay = document.getElementById('subtotal-display');
    const discountDisplay = document.getElementById('discount-display');
    const taxDisplay = document.getElementById('tax-display');
    const totalDisplay = document.getElementById('total-display');
    
    function calculateTotals() {
        const subtotal = parseFloat(subtotalInput.value) || 0;
        const discountPercentage = parseFloat(discountInput.value) || 0;
        const taxPercentage = parseFloat(taxInput.value) || 0;
        
        const discountValue = (subtotal * discountPercentage) / 100;
        const taxValue = ((subtotal - discountValue) * taxPercentage) / 100;
        const total = subtotal - discountValue + taxValue;
        
        subtotalDisplay.textContent = 'R$ ' + subtotal.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        discountDisplay.textContent = 'R$ ' + discountValue.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        taxDisplay.textContent = 'R$ ' + taxValue.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        totalDisplay.textContent = 'R$ ' + total.toLocaleString('pt-BR', {minimumFractionDigits: 2});
    }
    
    subtotalInput.addEventListener('input', calculateTotals);
    discountInput.addEventListener('input', calculateTotals);
    taxInput.addEventListener('input', calculateTotals);
    
    // Calcular valores iniciais
    calculateTotals();
});
</script>
@endsection
