@extends('panel.layout')

@section('page-title', 'Funcionários')
@section('page-subtitle', 'Gerencie sua equipe e vincule serviços')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-900">Funcionários</h2>
        <button onclick="document.getElementById('new-employee').classList.toggle('hidden')" class="px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold">Novo Funcionário</button>
    </div>

    <div id="new-employee" class="hidden bg-white rounded-lg border border-gray-200 p-4">
        <form method="POST" action="{{ route('panel.employees.store') }}" class="grid sm:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                <input name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                <input name="email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                <input name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cor (opcional)</label>
                <input name="color" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="#6c63ff" />
            </div>
            <!-- Vinculação de serviços é feita na tela de serviços -->
            <div class="sm:col-span-2">
                <label class="inline-flex items-center gap-2 text-sm mr-4">
                    <input type="checkbox" name="active" value="1" checked class="rounded border-gray-300" />
                    <span>Ativo</span>
                </label>
                <label class="inline-flex items-center gap-2 text-sm mr-4">
                    <input type="checkbox" name="show_in_booking" value="1" checked class="rounded border-gray-300" />
                    <span>Mostrar na Agenda</span>
                </label>
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold">Salvar</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Nome</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Contato</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Serviços</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($employees as $emp)
                <tr>
                    <td class="px-4 py-2">
                        <div class="font-semibold text-gray-900">{{ $emp->name }}</div>
                        <div class="text-xs text-gray-500">{{ $emp->active ? 'Ativo' : 'Inativo' }}</div>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-700">
                        {{ $emp->email }}<br>{{ $emp->phone }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-700">
                        {{ $emp->services->pluck('name')->join(', ') }}
                    </td>
                    <td class="px-4 py-2 text-right space-x-2">
                        <button onclick="document.getElementById('edit-{{ $emp->id }}').classList.toggle('hidden')" class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded-lg text-sm">Editar</button>
                        <form method="POST" action="{{ route('panel.employees.destroy', $emp) }}" class="inline" onsubmit="return confirm('Remover este funcionário?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 bg-red-600 text-white rounded-lg text-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
                <tr id="edit-{{ $emp->id }}" class="hidden bg-gray-50">
                    <td colspan="4" class="px-4 py-3">
                        <form method="POST" action="{{ route('panel.employees.update', $emp) }}" class="grid sm:grid-cols-4 gap-3 items-end">
                            @csrf @method('PUT')
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Nome</label>
                                <input name="name" value="{{ $emp->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg" />
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">E-mail</label>
                                <input name="email" type="email" value="{{ $emp->email }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg" />
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Telefone</label>
                                <input name="phone" value="{{ $emp->phone }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg" />
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Cor</label>
                                <input name="color" value="{{ $emp->color }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg" />
                            </div>
                            <div class="sm:col-span-4 flex flex-wrap gap-4 items-center">
                                <label class="inline-flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="active" value="1" {{ $emp->active ? 'checked' : '' }} class="rounded border-gray-300" />
                                    <span>Ativo</span>
                                </label>
                                <label class="inline-flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="show_in_booking" value="1" {{ $emp->show_in_booking ? 'checked' : '' }} class="rounded border-gray-300" />
                                    <span>Mostrar na Agenda</span>
                                </label>
                                <button class="ml-auto px-4 py-2 bg-purple-600 text-white rounded-lg text-sm">Salvar</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">Nenhum funcionário cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


