@extends('panel.layout')

@section('title', 'Editar Recibo - ' . $receipt->receipt_number)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Editar Recibo</h1>
            <p class="text-gray-600 mt-2">#{{ $receipt->receipt_number }} - {{ $receipt->event->title }}</p>
        </div>
        <a href="{{ route('panel.events.receipts.show', $receipt) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
            Voltar
        </a>
    </div>

    <!-- Event Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Evento: {{ $receipt->event->title }}</h3>
                <div class="mt-1 text-sm text-blue-700">
                    <p>Cliente: {{ $receipt->event->customer->name }}</p>
                    <p>Data: {{ \Carbon\Carbon::parse($receipt->event->event_date)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('panel.events.receipts.update', $receipt) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Hidden status field -->
            <input type="hidden" name="status" value="{{ $receipt->status }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Número do Recibo -->
                <div>
                    <label for="receipt_number" class="block text-sm font-medium text-gray-700 mb-2">Número do Recibo *</label>
                    <input type="text" id="receipt_number" name="receipt_number" value="{{ old('receipt_number', $receipt->receipt_number) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('receipt_number') border-red-500 @enderror" required>
                    @error('receipt_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data de Emissão -->
                <div>
                    <label for="receipt_date" class="block text-sm font-medium text-gray-700 mb-2">Data de Emissão *</label>
                    <input type="date" id="receipt_date" name="receipt_date" value="{{ old('receipt_date', $receipt->receipt_date) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('receipt_date') border-red-500 @enderror" required>
                    @error('receipt_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Valor -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Valor *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">R$</span>
                        </div>
                        <input type="number" id="amount" name="amount" step="0.01" min="0.01" value="{{ old('amount', $receipt->amount) }}" 
                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('amount') border-red-500 @enderror" required>
                    </div>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Forma de Pagamento -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Forma de Pagamento *</label>
                    <select id="payment_method" name="payment_method" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_method') border-red-500 @enderror" required>
                        <option value="">Selecione uma forma de pagamento</option>
                        <option value="dinheiro" {{ old('payment_method', $receipt->payment_method) == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                        <option value="pix" {{ old('payment_method', $receipt->payment_method) == 'pix' ? 'selected' : '' }}>PIX</option>
                        <option value="cartao_debito" {{ old('payment_method', $receipt->payment_method) == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                        <option value="cartao_credito" {{ old('payment_method', $receipt->payment_method) == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                        <option value="transferencia" {{ old('payment_method', $receipt->payment_method) == 'transferencia' ? 'selected' : '' }}>Transferência Bancária</option>
                        <option value="cheque" {{ old('payment_method', $receipt->payment_method) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                    </select>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Pagamento Relacionado -->
            <div>
                <label for="payment_id" class="block text-sm font-medium text-gray-700 mb-2">Pagamento Relacionado</label>
                <select id="payment_id" name="payment_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_id') border-red-500 @enderror">
                    <option value="">Nenhum pagamento relacionado</option>
                    @foreach($receipt->event->payments as $payment)
                        <option value="{{ $payment->id }}" {{ old('payment_id', $receipt->payment_id) == $payment->id ? 'selected' : '' }}>
                            R$ {{ number_format($payment->amount, 2, ',', '.') }} - {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }} - {{ ucfirst($payment->status) }}
                        </option>
                    @endforeach
                </select>
                @error('payment_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Observações -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                <textarea id="notes" name="notes" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror" 
                          placeholder="Observações adicionais sobre o recibo...">{{ old('notes', $receipt->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('panel.events.receipts.show', $receipt) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition-colors">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format currency input
    const amountInput = document.getElementById('amount');
    amountInput.addEventListener('input', function() {
        let value = this.value;
        if (value && !isNaN(value)) {
            this.value = parseFloat(value).toFixed(2);
        }
    });
});
</script>
@endsection
