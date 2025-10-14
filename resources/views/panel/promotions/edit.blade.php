@extends('panel.layout')

@section('title', 'Editar Promoção')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('panel.promotions.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
            ← Voltar para Promoções
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-pink-600 to-orange-600 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">✏️ Editar Promoção</h1>
        </div>

        <form action="{{ route('panel.promotions.update', $promotion->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Informações Básicas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título da Promoção *</label>
                    <input type="text" name="name" value="{{ old('name', $promotion->name) }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                        required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                    <textarea name="description" rows="3" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">{{ old('description', $promotion->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Promoção *</label>
                    <select name="type" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                        required>
                        <option value="discount" {{ old('type', $promotion->type) === 'discount' ? 'selected' : '' }}>Desconto</option>
                        <option value="package" {{ old('type', $promotion->type) === 'package' ? 'selected' : '' }}>Pacote</option>
                        <option value="bundle" {{ old('type', $promotion->type) === 'bundle' ? 'selected' : '' }}>Combo</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Código do Cupom</label>
                    <input type="text" name="promo_code" value="{{ old('promo_code', $promotion->promo_code) }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 uppercase"
                        maxlength="50"
                        placeholder="Deixe vazio para manter o atual">
                </div>
            </div>

            <!-- Desconto -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">💰 Valor do Desconto</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Desconto Percentual (%)</label>
                        <input type="number" step="0.01" name="discount_percentage" 
                            value="{{ old('discount_percentage', $promotion->discount_percentage) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                            min="0" max="100"
                            placeholder="Ex: 20">
                        <p class="text-xs text-gray-500 mt-1">Deixe vazio se usar valor fixo</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Desconto Fixo (R$)</label>
                        <input type="number" step="0.01" name="discount_fixed" 
                            value="{{ old('discount_fixed', $promotion->discount_fixed) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                            min="0"
                            placeholder="Ex: 50.00">
                        <p class="text-xs text-gray-500 mt-1">Deixe vazio se usar percentual</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Compra Mínima (R$)</label>
                        <input type="number" step="0.01" name="min_purchase" value="{{ old('min_purchase', $promotion->min_purchase) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                            min="0"
                            placeholder="Opcional">
                    </div>
                </div>
            </div>

            <!-- Serviços -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">✂️ Serviços (Opcional)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-60 overflow-y-auto">
                    @foreach($services as $service)
                        <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" 
                                {{ $promotion->service_ids && in_array($service->id, $promotion->service_ids) ? 'checked' : '' }}
                                class="w-5 h-5 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                            <div>
                                <span class="font-medium text-gray-900">{{ $service->name }}</span>
                                <span class="text-sm text-gray-600 block">R$ {{ number_format($service->price, 2, ',', '.') }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Validade e Limites -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📅 Validade e Limites</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Válido de *</label>
                        <input type="date" name="valid_from" value="{{ old('valid_from', \Carbon\Carbon::parse($promotion->valid_from)->format('Y-m-d')) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Válido até *</label>
                        <input type="date" name="valid_until" value="{{ old('valid_until', \Carbon\Carbon::parse($promotion->valid_until)->format('Y-m-d')) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Máximo de Usos Total</label>
                        <input type="number" name="max_uses" value="{{ old('max_uses', $promotion->max_uses) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                            min="1"
                            placeholder="Ilimitado">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Máximo de Usos por Cliente</label>
                        <input type="number" name="max_uses_per_customer" value="{{ old('max_uses_per_customer', $promotion->max_uses_per_customer) }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                            min="1">
                    </div>
                </div>
            </div>

            <!-- Segmentação -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">👥 Segmentação de Clientes (Opcional)</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Envie a promoção apenas para grupos específicos de clientes
                    <a href="{{ route('panel.promotions.segments') }}" class="text-purple-600 hover:underline ml-2">
                        (Ver Segmentos)
                    </a>
                </p>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Segmento Alvo</label>
                    <select name="target_segment" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="all" {{ old('target_segment', $promotion->target_segment ?? 'all') === 'all' ? 'selected' : '' }}>Todos os Clientes</option>
                        <option value="new" {{ old('target_segment', $promotion->target_segment) === 'new' ? 'selected' : '' }}>Novos Clientes (sem agendamentos)</option>
                        <option value="active" {{ old('target_segment', $promotion->target_segment) === 'active' ? 'selected' : '' }}>Clientes Ativos (últimos 30 dias)</option>
                        <option value="loyal" {{ old('target_segment', $promotion->target_segment) === 'loyal' ? 'selected' : '' }}>Clientes Fiéis (5+ agendamentos)</option>
                        <option value="inactive" {{ old('target_segment', $promotion->target_segment) === 'inactive' ? 'selected' : '' }}>Clientes Inativos (60+ dias)</option>
                    </select>
                </div>
            </div>

            <!-- Status -->
            <div class="border-t pt-6">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="active" value="1" {{ old('active', $promotion->active) ? 'checked' : '' }}
                        class="w-5 h-5 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                    <span class="text-gray-700 font-medium">Promoção Ativa</span>
                </label>
            </div>

            <!-- Ações -->
            <div class="flex gap-4 pt-4">
                <a href="{{ route('panel.promotions.index') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold text-center">
                    Cancelar
                </a>
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-pink-600 to-orange-600 text-white rounded-lg hover:shadow-lg transform hover:scale-105 transition font-semibold">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const discountType = document.getElementById('discount_type');
    const discountLabel = document.getElementById('discount_label');

    function updateLabel() {
        if (discountType.value === 'percentage') {
            discountLabel.textContent = 'Percentual (%) *';
        } else {
            discountLabel.textContent = 'Valor (R$) *';
        }
    }

    discountType.addEventListener('change', updateLabel);
    updateLabel();
</script>
@endsection

