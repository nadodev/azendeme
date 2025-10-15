@extends('panel.layout')

@section('page-title', 'Criar Pagamento')
@section('page-subtitle', 'Registre um novo pagamento para o evento')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('panel.events.payments.store', $event) }}" class="space-y-6">
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                {{ $event->event_date->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dados do Pagamento -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Dados do Pagamento</h3>
                    
                    <div class="space-y-4">
                        @if($invoices->count() > 0)
                            <div>
                                <label for="invoice_id" class="block text-sm font-medium text-gray-700 mb-2">Fatura *</label>
                                <select id="invoice_id" name="invoice_id" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                    <option value="">Selecione a fatura</option>
                                    @foreach($invoices as $invoice)
                                        <option value="{{ $invoice->id }}" 
                                                data-total="{{ $invoice->total }}" 
                                                data-paid="{{ $invoice->total_paid }}"
                                                data-remaining="{{ $invoice->remaining_amount }}">
                                            {{ $invoice->invoice_number }} - R$ {{ number_format($invoice->total, 2, ',', '.') }}
                                            @if($invoice->remaining_amount > 0)
                                                (Restante: R$ {{ number_format($invoice->remaining_amount, 2, ',', '.') }})
                                            @else
                                                (Paga)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        
                        <div>
                            <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-2">Data do Pagamento *</label>
                            <input type="date" id="payment_date" name="payment_date" 
                                   value="{{ now()->toDateString() }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Valor *</label>
                            <input type="number" id="amount" name="amount" step="0.01" min="0" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Método de Pagamento *</label>
                            <select id="payment_method" name="payment_method" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                <option value="">Selecione o método</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="cartao_credito">Cartão de Crédito</option>
                                <option value="cartao_debito">Cartão de Débito</option>
                                <option value="pix">PIX</option>
                                <option value="transferencia">Transferência</option>
                                <option value="cheque">Cheque</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="payment_reference" class="block text-sm font-medium text-gray-700 mb-2">Referência do Pagamento</label>
                            <input type="text" id="payment_reference" name="payment_reference" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="Ex: ID da transação, comprovante PIX, etc.">
                        </div>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                            <textarea id="notes" name="notes" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Observações sobre o pagamento..."></textarea>
                        </div>
                        
                        <!-- Campo status hidden -->
                        <input type="hidden" name="status" value="pendente">
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Faturas Relacionadas -->
                @if($event->invoices->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Faturas Relacionadas</h3>
                        
                        <div class="space-y-3">
                            @foreach($event->invoices as $invoice)
                                <div class="border border-gray-200 rounded-lg p-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium">{{ $invoice->invoice_number }}</p>
                                            <p class="text-sm text-gray-600">{{ $invoice->invoice_date->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium">R$ {{ number_format($invoice->total, 2, ',', '.') }}</p>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $invoice->status === 'paga' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Resumo Financeiro -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Resumo Financeiro</h3>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Total Faturado:</span>
                            <span class="font-medium">R$ {{ number_format($event->total_invoiced, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total Pago:</span>
                            <span class="font-medium">R$ {{ number_format($event->total_paid, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-t pt-2">
                            <span>Saldo Devedor:</span>
                            <span class="font-medium {{ $event->remaining_amount > 0 ? 'text-red-600' : 'text-green-600' }}">
                                R$ {{ number_format($event->remaining_amount, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Registrar Pagamento
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
    const amountInput = document.getElementById('amount');
    const invoiceSelect = document.getElementById('invoice_id');
    
    function updateAmountValidation() {
        if (invoiceSelect && invoiceSelect.value) {
            const selectedOption = invoiceSelect.options[invoiceSelect.selectedIndex];
            const remainingAmount = parseFloat(selectedOption.dataset.remaining);
            
            // Sugerir o valor do saldo devedor
            if (remainingAmount > 0) {
                amountInput.value = remainingAmount;
            }
            
            // Remover event listeners anteriores
            amountInput.removeEventListener('input', validateAmount);
            
            // Validação do valor
            function validateAmount() {
                const value = parseFloat(this.value);
                if (value > remainingAmount) {
                    this.setCustomValidity('O valor não pode ser maior que o saldo devedor (R$ ' + remainingAmount.toFixed(2).replace('.', ',') + ')');
                } else {
                    this.setCustomValidity('');
                }
            }
            
            amountInput.addEventListener('input', validateAmount);
        }
    }
    
    if (invoiceSelect) {
        invoiceSelect.addEventListener('change', updateAmountValidation);
        updateAmountValidation();
    }
});
</script>
@endsection
