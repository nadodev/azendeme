@extends('panel.layout')

@section('page-title', 'Clientes')
@section('page-subtitle', 'Gerencie sua base de clientes')

@section('header-actions')
    <a href="{{ route('panel.clientes.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition inline-flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Novo Cliente</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Busca -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('panel.clientes.index') }}">
            <div class="flex space-x-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome, telefone ou email..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                    Buscar
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Clientes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contato</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agendamentos</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-semibold text-sm">{{ substr($customer->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $customer->name }}</p>
                                        @if($customer->notes)
                                            <p class="text-xs text-gray-500">{{ Str::limit($customer->notes, 40) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900">{{ $customer->phone }}</p>
                                @if($customer->email)
                                    <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold text-purple-700 bg-purple-100 rounded-full">
                                    {{ $customer->appointments_count }} agendamento(s)
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('panel.clientes.show', $customer) }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">Ver</a>
                                <a href="{{ route('panel.clientes.edit', $customer) }}" class="text-gray-600 hover:text-gray-700 text-sm font-medium">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <p class="text-gray-500">Nenhum cliente encontrado</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

