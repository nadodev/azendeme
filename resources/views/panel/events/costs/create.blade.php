@extends('panel.layout')

@section('title', 'Novo Custo')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Novo Custo</h1>
            <p class="text-gray-600">Registre um novo custo para o evento: {{ $event->title }}</p>
        </div>
        <a href="{{ route('panel.events.costs.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            Voltar
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('panel.events.costs.store', $event) }}" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Categoria -->
                <div>
                    <label for="cost_category_id" class="block text-sm font-medium text-gray-700 mb-2">Categoria *</label>
                    <select id="cost_category_id" name="cost_category_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('cost_category_id') border-red-500 @enderror" 
                            required>
                        <option value="">Selecione uma categoria</option>
                        @foreach($costCategories as $category)
                            <option value="{{ $category->id }}" {{ old('cost_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cost_category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data do Custo -->
                <div>
                    <label for="cost_date" class="block text-sm font-medium text-gray-700 mb-2">Data do Custo *</label>
                    <input type="date" id="cost_date" name="cost_date" value="{{ old('cost_date', now()->format('Y-m-d')) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('cost_date') border-red-500 @enderror" 
                           required>
                    @error('cost_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Descrição -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição *</label>
                <input type="text" id="description" name="description" value="{{ old('description') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror" 
                       placeholder="Ex: Combustível para deslocamento" required>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Detalhes -->
            <div>
                <label for="details" class="block text-sm font-medium text-gray-700 mb-2">Detalhes</label>
                <textarea id="details" name="details" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('details') border-red-500 @enderror" 
                          placeholder="Detalhes adicionais sobre o custo...">{{ old('details') }}</textarea>
                @error('details')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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

                <!-- Tipo de Custo -->
                <div>
                    <label for="cost_type" class="block text-sm font-medium text-gray-700 mb-2">Tipo *</label>
                    <select id="cost_type" name="cost_type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('cost_type') border-red-500 @enderror" 
                            required>
                        <option value="">Selecione o tipo</option>
                        <option value="fixo" {{ old('cost_type') == 'fixo' ? 'selected' : '' }}>Fixo</option>
                        <option value="variavel" {{ old('cost_type') == 'variavel' ? 'selected' : '' }}>Variável</option>
                        <option value="imprevisto" {{ old('cost_type') == 'imprevisto' ? 'selected' : '' }}>Imprevisto</option>
                    </select>
                    @error('cost_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status do Pagamento -->
                <div>
                    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Status do Pagamento *</label>
                    <select id="payment_status" name="payment_status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_status') border-red-500 @enderror" 
                            required>
                        <option value="">Selecione o status</option>
                        <option value="pendente" {{ old('payment_status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="pago" {{ old('payment_status') == 'pago' ? 'selected' : '' }}>Pago</option>
                        <option value="parcelado" {{ old('payment_status') == 'parcelado' ? 'selected' : '' }}>Parcelado</option>
                    </select>
                    @error('payment_status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data de Vencimento -->
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Data de Vencimento</label>
                    <input type="date" id="due_date" name="due_date" value="{{ old('due_date') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('due_date') border-red-500 @enderror">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fornecedor -->
                <div>
                    <label for="supplier" class="block text-sm font-medium text-gray-700 mb-2">Fornecedor</label>
                    <input type="text" id="supplier" name="supplier" value="{{ old('supplier') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('supplier') border-red-500 @enderror" 
                           placeholder="Nome do fornecedor">
                    @error('supplier')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Número da Nota Fiscal -->
                <div>
                    <label for="invoice_number" class="block text-sm font-medium text-gray-700 mb-2">Número da Nota Fiscal</label>
                    <input type="text" id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('invoice_number') border-red-500 @enderror" 
                           placeholder="Número da NF">
                    @error('invoice_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Referência do Pagamento -->
                <div>
                    <label for="payment_reference" class="block text-sm font-medium text-gray-700 mb-2">Referência do Pagamento</label>
                    <input type="text" id="payment_reference" name="payment_reference" value="{{ old('payment_reference') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_reference') border-red-500 @enderror" 
                           placeholder="Comprovante, PIX, etc.">
                    @error('payment_reference')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
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
                <a href="{{ route('panel.events.costs.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    Registrar Custo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
