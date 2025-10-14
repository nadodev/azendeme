@extends('panel.layout')

@section('page-title', 'Criar Link Rápido')
@section('page-subtitle', 'Crie um link para agendamentos rápidos')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('panel.quick-booking.store') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Link *</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ex: Agendamento Rápido Setembro" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <p class="mt-1 text-sm text-gray-500">Nome interno para identificar o link</p>
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
            <textarea name="description" rows="3" placeholder="Descreva o propósito deste link..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Serviço Específico</label>
            <select name="service_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">Qualquer serviço (cliente escolhe)</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                        {{ $service->name }} - R$ {{ number_format($service->price, 2, ',', '.') }}
                    </option>
                @endforeach
            </select>
            <p class="mt-1 text-sm text-gray-500">Deixe vazio para permitir qualquer serviço</p>
            @error('service_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Limites e Restrições</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Máximo de Usos</label>
                    <input type="number" name="max_uses" value="{{ old('max_uses') }}" min="1" placeholder="Ilimitado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">Deixe vazio para ilimitado</p>
                    @error('max_uses')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Data de Expiração</label>
                    <input type="date" name="expires_at" value="{{ old('expires_at') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">Deixe vazio para nunca expirar</p>
                    @error('expires_at')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-900">Como Funciona</p>
                    <p class="text-sm text-blue-700 mt-1">Um link único será gerado. Compartilhe-o em redes sociais, WhatsApp ou e-mail. Os clientes podem agendar diretamente sem login.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('panel.quick-booking.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                Criar Link
            </button>
        </div>
    </form>
</div>
@endsection

