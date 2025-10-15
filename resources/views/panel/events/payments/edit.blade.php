@extends('panel.layout')

@section('page-title', 'Editar Pagamento')
@section('page-subtitle', 'Edite as informações do pagamento')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('panel.events.payments.update', $payment) }}" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informações do Evento -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Evento</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cliente</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                {{ $payment->event->customer->name }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Evento</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                {{ $payment->event->title }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                {{ ucfirst($payment->event->type) }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data</label>
                            <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                {{ $payment->event->event_date->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dados do Pagamento -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Dados do Pagamento</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-2">Data do Pagamento *</label>
                            <input type="date" id="payment_date" name="payment_date" 
                                   value="{{ $payment->payment_date->toDateString() }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Valor *</label>
                            <input type="number" id="amount" name="amount" step="0.01" min="0" 
                                   value="{{ $payment->amount }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Método de Pagamento *</label>
                            <select id="payment_method" name="payment_method" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                <option value="">Selecione o método</option>
                                <option value="dinheiro" {{ $payment->payment_method === 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                                <option value="cartao_credito" {{ $payment->payment_method === 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                                <option value="cartao_debito" {{ $payment->payment_method === 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                                <option value="pix" {{ $payment->payment_method === 'pix' ? 'selected' : '' }}>PIX</option>
                                <option value="transferencia" {{ $payment->payment_method === 'transferencia' ? 'selected' : '' }}>Transferência</option>
                                <option value="cheque" {{ $payment->payment_method === 'cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="outro" {{ $payment->payment_method === 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="payment_reference" class="block text-sm font-medium text-gray-700 mb-2">Referência do Pagamento</label>
                            <input type="text" id="payment_reference" name="payment_reference" 
                                   value="{{ $payment->payment_reference }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="Ex: ID da transação, comprovante PIX, etc.">
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select id="status" name="status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                <option value="pendente" {{ $payment->status === 'pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="confirmado" {{ $payment->status === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                <option value="cancelado" {{ $payment->status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                            <textarea id="notes" name="notes" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Observações sobre o pagamento...">{{ $payment->notes }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Informações do Pagamento -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Pagamento</h3>
                    
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="font-medium">Número:</span>
                            <span class="text-gray-600">{{ $payment->payment_number }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Criado em:</span>
                            <span class="text-gray-600">{{ $payment->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Atualizado em:</span>
                            <span class="text-gray-600">{{ $payment->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Fatura Relacionada -->
                @if($payment->invoice)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Fatura Relacionada</h3>
                        
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium">{{ $payment->invoice->invoice_number }}</p>
                                    <p class="text-sm text-gray-600">{{ $payment->invoice->invoice_date->format('d/m/Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">R$ {{ number_format($payment->invoice->total, 2, ',', '.') }}</p>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $payment->invoice->status === 'paga' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($payment->invoice->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('panel.events.invoices.show', $payment->invoice) }}" class="text-sm text-purple-600 hover:text-purple-900">Ver Fatura</a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Ações -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Atualizar Pagamento
                        </button>
                        <a href="{{ route('panel.events.payments.show', $payment) }}" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-center block">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
