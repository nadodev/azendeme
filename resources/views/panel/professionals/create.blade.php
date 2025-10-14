@extends('panel.layout')

@section('title', 'Novo Profissional')

@section('content')
<div class="p-8 max-w-3xl mx-auto">
    <!-- Cabeçalho -->
    <div class="mb-6">
        <a href="{{ route('panel.professionals.index') }}" class="text-purple-600 hover:text-purple-700 flex items-center space-x-2 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Voltar</span>
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Novo Profissional</h1>
        <p class="text-gray-600 mt-1">Adicione um novo membro à sua equipe</p>
    </div>

    <!-- Formulário -->
    <form action="{{ route('panel.professionals.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        @csrf

        <!-- Foto -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Foto do Profissional</label>
            <div class="flex items-center space-x-4">
                <div id="preview" class="w-24 h-24 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white text-3xl font-bold">
                    ?
                </div>
                <div class="flex-1">
                    <input type="file" name="photo" id="photo" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG ou JPEG até 2MB</p>
                </div>
            </div>
            @error('photo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nome -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-6">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">E-mail *</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Telefone -->
        <div class="mb-6">
            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Telefone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="(00) 00000-0000" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            @error('phone')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Especialidade -->
        <div class="mb-6">
            <label for="specialty" class="block text-sm font-semibold text-gray-700 mb-2">Especialidade</label>
            <input type="text" name="specialty" id="specialty" value="{{ old('specialty') }}" placeholder="Ex: Cabeleireiro, Manicure, Massagista" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            @error('specialty')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Comissão -->
        <div class="mb-6">
            <label for="commission_percentage" class="block text-sm font-semibold text-gray-700 mb-2">Percentual de Comissão (%)</label>
            <input type="number" name="commission_percentage" id="commission_percentage" value="{{ old('commission_percentage', 0) }}" min="0" max="100" step="0.01" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">Deixe 0 se não trabalhar com comissão</p>
            @error('commission_percentage')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bio -->
        <div class="mb-6">
            <label for="bio" class="block text-sm font-semibold text-gray-700 mb-2">Sobre o Profissional</label>
            <textarea name="bio" id="bio" rows="4" placeholder="Descrição breve sobre o profissional..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('bio') }}</textarea>
            @error('bio')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botões -->
        <div class="flex space-x-4">
            <button type="submit" class="flex-1 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                Cadastrar Profissional
            </button>
            <a href="{{ route('panel.professionals.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    // Preview da foto
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').innerHTML = `<img src="${e.target.result}" class="w-24 h-24 rounded-full object-cover">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // Atualizar inicial no preview conforme digita o nome
    document.getElementById('name').addEventListener('input', function(e) {
        const preview = document.getElementById('preview');
        if (!document.querySelector('#preview img')) {
            preview.textContent = e.target.value.charAt(0).toUpperCase() || '?';
        }
    });
</script>
@endsection

