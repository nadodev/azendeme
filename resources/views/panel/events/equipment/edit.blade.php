@extends('panel.layout')

@section('page-title', 'Editar Equipamento')
@section('page-subtitle', 'Edite as informações do equipamento')

@section('header-actions')
    <a href="{{ route('panel.events.equipment.show', $equipment) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition inline-flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Voltar</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <form action="{{ route('panel.events.equipment.update', $equipment) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Formulário Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informações Básicas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações do Equipamento</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome do Equipamento *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $equipment->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                            <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $equipment->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">Valor por Hora *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">R$</span>
                                    </div>
                                    <input type="number" id="hourly_rate" name="hourly_rate" step="0.01" min="0" value="{{ old('hourly_rate', $equipment->hourly_rate) }}" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('hourly_rate') border-red-500 @enderror" required>
                                </div>
                                @error('hourly_rate')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="minimum_hours" class="block text-sm font-medium text-gray-700 mb-2">Horas Mínimas *</label>
                                <div class="relative">
                                    <input type="number" id="minimum_hours" name="minimum_hours" min="1" value="{{ old('minimum_hours', $equipment->minimum_hours) }}" class="w-full pr-12 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('minimum_hours') border-red-500 @enderror" required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">horas</span>
                                    </div>
                                </div>
                                @error('minimum_hours')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Especificações Técnicas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Especificações Técnicas</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="setup_requirements" class="block text-sm font-medium text-gray-700 mb-2">Requisitos de Montagem</label>
                            <textarea id="setup_requirements" name="setup_requirements" rows="4" placeholder="Ex: Espaço mínimo de 3x3m, tomada 220V, acesso para montagem, etc." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('setup_requirements') border-red-500 @enderror">{{ old('setup_requirements', $equipment->setup_requirements) }}</textarea>
                            @error('setup_requirements')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="technical_specs" class="block text-sm font-medium text-gray-700 mb-2">Especificações Técnicas</label>
                            <textarea id="technical_specs" name="technical_specs" rows="4" placeholder="Ex: Resolução 4K, 50 fotos por sessão, iluminação LED, etc." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('technical_specs') border-red-500 @enderror">{{ old('technical_specs', $equipment->technical_specs) }}</textarea>
                            @error('technical_specs')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $equipment->is_active) ? 'checked' : '' }} class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Equipamento ativo
                        </label>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Equipamentos inativos não aparecerão na lista de seleção ao criar eventos.</p>
                </div>

                <!-- Estatísticas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Estatísticas</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Eventos realizados:</span>
                            <span class="font-medium text-gray-900">{{ $equipment->services->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Horas totais:</span>
                            <span class="font-medium text-gray-900">{{ $equipment->services->sum('hours') }}h</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Faturamento:</span>
                            <span class="font-medium text-gray-900">R$ {{ number_format($equipment->services->sum('total_value'), 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Salvar Alterações
                        </button>
                        <a href="{{ route('panel.events.equipment.show', $equipment) }}" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-center block">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
