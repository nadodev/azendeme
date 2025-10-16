@extends('panel.layout')

@section('page-title', 'Editar Serviço')
@section('page-subtitle', 'Atualize os dados do serviço')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('panel.servicos.update', ['servico' => $servico->id]) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Serviço *</label>
                    <input type="text" name="name" value="{{ old('name', $servico->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Ex: Corte de Cabelo">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Descrição do serviço...">{{ old('description', $servico->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Duração (minutos) *</label>
                        <input type="number" name="duration" value="{{ old('duration', $servico->duration) }}" required min="5" step="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="60">
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preço (R$)</label>
                        <input type="number" name="price" value="{{ old('price', $servico->price) }}" min="0" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="150.00">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Profissional Responsável</label>
                    <select name="assigned_employer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="">Qualquer profissional disponível</option>
                        @foreach($employees as $professional)
                            <option value="{{ $professional->id }}" {{ old('assigned_employer_id', $servico->assigned_employer_id) == $professional->id ? 'selected' : '' }}>
                                {{ $professional->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Deixe vazio para permitir que qualquer profissional realize este serviço</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Funcionários que executam este serviço</label>
                    <div class="grid sm:grid-cols-2 gap-2">
                        @php
                            $selected = old('employee_ids', $servico->employees->pluck('id')->toArray());
                        @endphp
                        @foreach(($employees ?? []) as $emp)
                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox" name="employee_ids[]" value="{{ $emp->id }}" class="rounded border-gray-300" {{ in_array($emp->id, $selected) ? 'checked' : '' }} />
                                <span>{{ $emp->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Selecione os funcionários que podem atender este serviço.</p>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="active" value="1" {{ old('active', $servico->active) ? 'checked' : '' }} class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Serviço ativo (disponível para agendamento)</span>
                    </label>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="allows_multiple" value="1" {{ old('allows_multiple', $servico->allows_multiple) ? 'checked' : '' }} class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Permitir adicionar múltiplos deste serviço no agendamento</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-1">Dica</h4>
                    <p class="text-sm text-blue-800">
                        A duração do serviço será usada para calcular os horários disponíveis no agendamento online.
                        Defina um tempo que inclua a execução do serviço + tempo de preparação/limpeza.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('panel.servicos.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                Salvar Alterações
            </button>
        </div>
    </form>
</div>
@endsection

