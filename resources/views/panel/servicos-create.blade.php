@extends('panel.layout')

@section('page-title', 'Novo Serviço')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('panel.servicos.store') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Serviço *</label>
            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Duração (minutos) *</label>
                <input type="number" name="duration" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Preço (R$)</label>
                <input type="number" name="price" step="0.01" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Profissional Responsável</label>
            <select name="assigned_professional_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <option value="">Qualquer profissional disponível</option>
                @foreach($professionals as $professional)
                    <option value="{{ $professional->id }}">{{ $professional->name }}@if($professional->specialty) - {{ $professional->specialty }}@endif</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Deixe vazio para permitir que qualquer profissional realize este serviço</p>
        </div>

        <div>
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="active" value="1" checked class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="text-sm text-gray-700">Serviço ativo</span>
            </label>
        </div>

        <div>
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="allows_multiple" value="1" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="text-sm text-gray-700">Permitir adicionar múltiplos deste serviço no agendamento</span>
            </label>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('panel.servicos.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                Criar Serviço
            </button>
        </div>
    </form>
</div>
@endsection

