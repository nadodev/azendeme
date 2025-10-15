@extends('panel.layout')

@section('title', 'Novo Recibo')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Novo Recibo</h1>
            <p class="text-gray-600">Crie um recibo para o evento: {{ $event->title }}</p>
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
        <form method="POST" action="{{ route('panel.events.receipts.store', $event) }}" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data do Recibo -->
                <div>
                    <label for="receipt_date" class="block text-sm font-medium text-gray-700 mb-2">Data do Recibo *</label>
                    <input type="date" id="receipt_date" name="receipt_date" value="{{ old('receipt_date', now()->format('Y-m-d')) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('receipt_date') border-red-500 @enderror" 
                           required>
                    @error('receipt_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pagamento -->
                <div>
                    <label for="payment_id" class="block text-sm font-medium text-gray-700 mb-2">Pagamento</label>
                    <select id="payment_id" name="payment_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_id') border-red-500 @enderror">
                        <option value="">Selecione um pagamento (opcional)</option>
                        @foreach($payments as $payment)
                            <option value="{{ $payment->id }}" {{ old('payment_id') == $payment->id ? 'selected' : '' }}>
                                {{ $payment->payment_number }} - R$ {{ number_format($payment->amount, 2, ',', '.') }} ({{ $payment->payment_method_label }})
                            </option>
                        @endforeach
                    </select>
                    @error('payment_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Descrição -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição do Pagamento *</label>
                <textarea id="description" name="description" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror" 
                          placeholder="Descreva o pagamento recebido..." required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Valor -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Valor *</label>
                    <input type="number" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0.01" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('amount') border-red-500 @enderror" 
                           placeholder="0,00" required>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Método de Pagamento -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Método de Pagamento *</label>
                    <select id="payment_method" name="payment_method" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_method') border-red-500 @enderror" 
                            required>
                        <option value="">Selecione o método</option>
                        <option value="dinheiro" {{ old('payment_method') == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                        <option value="cartao_credito" {{ old('payment_method') == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                        <option value="cartao_debito" {{ old('payment_method') == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                        <option value="pix" {{ old('payment_method') == 'pix' ? 'selected' : '' }}>PIX</option>
                        <option value="transferencia" {{ old('payment_method') == 'transferencia' ? 'selected' : '' }}>Transferência</option>
                        <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        <option value="outro" {{ old('payment_method') == 'outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Referência do Pagamento -->
            <div>
                <label for="payment_reference" class="block text-sm font-medium text-gray-700 mb-2">Referência do Pagamento</label>
                <input type="text" id="payment_reference" name="payment_reference" value="{{ old('payment_reference') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_reference') border-red-500 @enderror" 
                       placeholder="PIX, comprovante, número do cartão, etc.">
                @error('payment_reference')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dados do Pagador -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Dados do Pagador</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nome do Pagador -->
                    <div>
                        <label for="payer_name" class="block text-sm font-medium text-gray-700 mb-2">Nome do Pagador *</label>
                        <input type="text" id="payer_name" name="payer_name" value="{{ old('payer_name', $event->customer->name) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payer_name') border-red-500 @enderror" 
                               placeholder="Nome completo" required>
                        @error('payer_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CPF/CNPJ -->
                    <div>
                        <label for="payer_document" class="block text-sm font-medium text-gray-700 mb-2">CPF/CNPJ</label>
                        <input type="text" id="payer_document" name="payer_document" value="{{ old('payer_document') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payer_document') border-red-500 @enderror" 
                               placeholder="000.000.000-00">
                        @error('payer_document')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Endereço do Pagador -->
                <div class="mt-6">
                    <label for="payer_address" class="block text-sm font-medium text-gray-700 mb-2">Endereço do Pagador</label>
                    <textarea id="payer_address" name="payer_address" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payer_address') border-red-500 @enderror" 
                              placeholder="Endereço completo...">{{ old('payer_address') }}</textarea>
                    @error('payer_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Descrição dos Serviços -->
            <div>
                <label for="services_description" class="block text-sm font-medium text-gray-700 mb-2">Descrição dos Serviços *</label>
                <textarea id="services_description" name="services_description" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('services_description') border-red-500 @enderror" 
                          placeholder="Descreva os serviços prestados..." required>{{ old('services_description') }}</textarea>
                @error('services_description')
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
                    Criar Recibo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
