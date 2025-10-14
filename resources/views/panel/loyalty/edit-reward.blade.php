@extends('panel.layout')

@section('title', 'Editar Recompensa')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('panel.loyalty.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
            ← Voltar para Fidelidade
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-pink-600 to-orange-600 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">✏️ Editar Recompensa</h1>
        </div>

        <form action="{{ route('panel.loyalty.update-reward', $reward->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome da Recompensa *</label>
                <input type="text" name="name" value="{{ old('name', $reward->name) }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                <textarea name="description" rows="3" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">{{ old('description', $reward->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pontos Necessários *</label>
                    <input type="number" name="points_required" value="{{ old('points_required', $reward->points_required) }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                        min="1"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Desconto *</label>
                    <select name="reward_type" id="reward_type" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                        required>
                        <option value="percentage" {{ old('reward_type', $reward->reward_type) === 'percentage' ? 'selected' : '' }}>Percentual (%)</option>
                        <option value="fixed" {{ old('reward_type', $reward->reward_type) === 'fixed' ? 'selected' : '' }}>Valor Fixo (R$)</option>
                        <option value="free_service" {{ old('reward_type', $reward->reward_type) === 'free_service' ? 'selected' : '' }}>Serviço Grátis</option>
                    </select>
                </div>

                <div id="discount_value_container">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <span id="discount_label">Valor do Desconto *</span>
                    </label>
                    <input type="number" step="0.01" name="discount_value" id="discount_value" 
                        value="{{ old('discount_value', $reward->discount_value) }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                        min="0"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Válido até</label>
                    <input type="date" name="valid_until" value="{{ old('valid_until', $reward->valid_until ? \Carbon\Carbon::parse($reward->valid_until)->format('Y-m-d') : '') }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Máximo de Usos</label>
                    <input type="number" name="max_redemptions" value="{{ old('max_redemptions', $reward->max_redemptions) }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                        min="1"
                        placeholder="Ilimitado">
                </div>
            </div>

            <div>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="active" value="1" {{ old('active', $reward->active) ? 'checked' : '' }}
                        class="w-5 h-5 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                    <span class="text-gray-700 font-medium">Recompensa Ativa</span>
                </label>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="{{ route('panel.loyalty.index') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold text-center">
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
    const rewardType = document.getElementById('reward_type');
    const discountValue = document.getElementById('discount_value');
    const discountLabel = document.getElementById('discount_label');
    const discountContainer = document.getElementById('discount_value_container');

    function updateDiscountField() {
        if (rewardType.value === 'free_service') {
            discountContainer.style.display = 'none';
            discountValue.required = false;
        } else {
            discountContainer.style.display = 'block';
            discountValue.required = true;
            if (rewardType.value === 'percentage') {
                discountLabel.textContent = 'Percentual de Desconto (%) *';
                discountValue.max = 100;
            } else {
                discountLabel.textContent = 'Valor do Desconto (R$) *';
                discountValue.removeAttribute('max');
            }
        }
    }

    rewardType.addEventListener('change', updateDiscountField);
    updateDiscountField();
</script>
@endsection

