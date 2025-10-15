@extends('panel.layout')

@section('title', 'Editar Custo - ' . $cost->description)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Editar Custo</h1>
            <p class="text-gray-600 mt-2">{{ $cost->description }} - {{ $cost->event->title }}</p>
        </div>
        <a href="{{ route('panel.events.costs.show', $cost) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
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
                <h3 class="text-sm font-medium text-blue-800">Evento: {{ $cost->event->title }}</h3>
                <div class="mt-1 text-sm text-blue-700">
                    <p>Cliente: {{ $cost->event->customer->name }}</p>
                    <p>Data: {{ \Carbon\Carbon::parse($cost->event->event_date)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('panel.events.costs.update', $cost) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Hidden status field -->
            <input type="hidden" name="status" value="{{ $cost->status }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Descrição -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição do Custo *</label>
                    <input type="text" id="description" name="description" value="{{ old('description', $cost->description) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror" required>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categoria -->
                <div>
                    <label for="cost_category_id" class="block text-sm font-medium text-gray-700 mb-2">Categoria *</label>
                    <select id="cost_category_id" name="cost_category_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('cost_category_id') border-red-500 @enderror" required>
                        <option value="">Selecione uma categoria</option>
                        @foreach($costCategories as $category)
                            <option value="{{ $category->id }}" {{ old('cost_category_id', $cost->cost_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cost_category_id')
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
                        <input type="number" id="amount" name="amount" step="0.01" min="0.01" value="{{ old('amount', $cost->amount) }}" 
                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('amount') border-red-500 @enderror" required>
                    </div>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data do Custo -->
                <div>
                    <label for="cost_date" class="block text-sm font-medium text-gray-700 mb-2">Data do Custo *</label>
                    <input type="date" id="cost_date" name="cost_date" value="{{ old('cost_date', $cost->cost_date) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('cost_date') border-red-500 @enderror" required>
                    @error('cost_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fornecedor -->
                <div>
                    <label for="supplier" class="block text-sm font-medium text-gray-700 mb-2">Fornecedor</label>
                    <input type="text" id="supplier" name="supplier" value="{{ old('supplier', $cost->supplier) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('supplier') border-red-500 @enderror">
                    @error('supplier')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Número da Nota -->
                <div>
                    <label for="invoice_number" class="block text-sm font-medium text-gray-700 mb-2">Número da Nota</label>
                    <input type="text" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $cost->invoice_number) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('invoice_number') border-red-500 @enderror">
                    @error('invoice_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data do Pagamento -->
                <div>
                    <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-2">Data do Pagamento</label>
                    <input type="date" id="payment_date" name="payment_date" value="{{ old('payment_date', $cost->payment_date) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_date') border-red-500 @enderror">
                    @error('payment_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Método de Pagamento -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Método de Pagamento</label>
                    <select id="payment_method" name="payment_method" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_method') border-red-500 @enderror">
                        <option value="">Selecione um método</option>
                        <option value="dinheiro" {{ old('payment_method', $cost->payment_method) == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                        <option value="pix" {{ old('payment_method', $cost->payment_method) == 'pix' ? 'selected' : '' }}>PIX</option>
                        <option value="cartao_debito" {{ old('payment_method', $cost->payment_method) == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                        <option value="cartao_credito" {{ old('payment_method', $cost->payment_method) == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                        <option value="transferencia" {{ old('payment_method', $cost->payment_method) == 'transferencia' ? 'selected' : '' }}>Transferência Bancária</option>
                        <option value="cheque" {{ old('payment_method', $cost->payment_method) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        <option value="outro" {{ old('payment_method', $cost->payment_method) == 'outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                    @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Referência do Pagamento -->
                <div>
                    <label for="payment_reference" class="block text-sm font-medium text-gray-700 mb-2">Referência do Pagamento</label>
                    <input type="text" id="payment_reference" name="payment_reference" value="{{ old('payment_reference', $cost->payment_reference) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_reference') border-red-500 @enderror">
                    @error('payment_reference')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Observações -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                <textarea id="notes" name="notes" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror" 
                          placeholder="Observações adicionais sobre o custo...">{{ old('notes', $cost->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('panel.events.costs.show', $cost) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors">
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
