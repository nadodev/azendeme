@extends('panel.layout')

@section('page-title', 'Editar Link Rápido')
@section('page-subtitle', 'Atualize as configurações do link')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('panel.quick-booking.update', $link->id) }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Link *</label>
            <input type="text" name="name" value="{{ old('name', $link->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('description', $link->description) }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Serviço Específico</label>
            <select name="service_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">Qualquer serviço (cliente escolhe)</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id', $link->service_id) == $service->id ? 'selected' : '' }}>
                        {{ $service->name }} - R$ {{ number_format($service->price, 2, ',', '.') }}
                    </option>
                @endforeach
            </select>
            @error('service_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Limites e Restrições</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Máximo de Usos</label>
                    <input type="number" name="max_uses" value="{{ old('max_uses', $link->max_uses) }}" min="1" placeholder="Ilimitado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">Usos atuais: {{ $link->uses_count }}</p>
                    @error('max_uses')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Data de Expiração</label>
                    <input type="date" name="expires_at" value="{{ old('expires_at', $link->expires_at ? $link->expires_at->format('Y-m-d') : '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('expires_at')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="active" value="1" {{ old('active', $link->active) ? 'checked' : '' }} class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                <span class="ml-2 text-sm font-medium text-gray-900">Link Ativo</span>
            </label>
            <p class="mt-1 text-sm text-gray-500 ml-6">Desmarque para desativar temporariamente</p>
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <p class="text-sm font-medium text-gray-900 mb-2">URL do Link:</p>
            <div class="flex items-center gap-2">
                <input type="text" value="{{ $link->url }}" readonly class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600">
                <button type="button" onclick="copyLink('{{ $link->url }}')" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                    Copiar
                </button>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('panel.quick-booking.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                Atualizar Link
            </button>
        </div>
    </form>
</div>

<script>
function copyLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert('Link copiado para a área de transferência!');
    }).catch(err => {
        console.error('Erro ao copiar:', err);
    });
}
</script>
@endsection

