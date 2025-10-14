@extends('panel.layout')

@section('page-title', 'Nova Transação')
@section('page-subtitle', 'Registre uma nova receita ou despesa')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('panel.financeiro.transacoes.store') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf

        <!-- Tipo de Transação -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de Transação</label>
            <div class="grid grid-cols-2 gap-4">
                <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition" id="income-label">
                    <input type="radio" name="type" value="income" class="sr-only" required>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Receita</p>
                            <p class="text-xs text-gray-500">Entrada de dinheiro</p>
                        </div>
                    </div>
                </label>

                <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition" id="expense-label">
                    <input type="radio" name="type" value="expense" class="sr-only" required>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Despesa</p>
                            <p class="text-xs text-gray-500">Saída de dinheiro</p>
                        </div>
                    </div>
                </label>
            </div>
            @error('type')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Categoria -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Selecione...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }} ({{ $category->type === 'income' ? 'Receita' : 'Despesa' }})</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Método de Pagamento -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pagamento</label>
                <select name="payment_method_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Selecione...</option>
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                    @endforeach
                </select>
                @error('payment_method_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Valor -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Valor (R$)</label>
                <input type="number" name="amount" step="0.01" min="0.01" required placeholder="0,00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                @error('amount')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Data -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Data da Transação</label>
                <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                @error('transaction_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Descrição -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
            <input type="text" name="description" required placeholder="Ex: Pagamento de serviço" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            @error('description')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Observações -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Observações (opcional)</label>
            <textarea name="notes" rows="3" placeholder="Informações adicionais..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
            @error('notes')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botões -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors">
                Salvar Transação
            </button>
            <a href="{{ route('panel.financeiro.transacoes') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    // Visual feedback para seleção do tipo
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('label[id$="-label"]').forEach(label => {
                label.classList.remove('border-purple-500', 'bg-purple-50');
                label.classList.add('border-gray-300');
            });
            
            if (this.checked) {
                const label = this.closest('label');
                label.classList.remove('border-gray-300');
                label.classList.add('border-purple-500', 'bg-purple-50');
            }
        });
    });
</script>
@endsection

