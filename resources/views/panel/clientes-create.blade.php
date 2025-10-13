@extends('panel.layout')

@section('page-title', 'Novo Cliente')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('panel.clientes.store') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo *</label>
            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Telefone *</label>
                <input type="text" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
            <textarea name="notes" rows="3" placeholder="Preferências, alergias, informações relevantes..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"></textarea>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('panel.clientes.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                Cadastrar Cliente
            </button>
        </div>
    </form>
</div>
@endsection

