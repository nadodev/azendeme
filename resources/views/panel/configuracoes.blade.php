@extends('panel.layout')

@section('page-title', 'Configurações')
@section('page-subtitle', 'Personalize seu perfil e preferências')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('panel.configuracoes.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Informações do Negócio -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Informações do Negócio</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Profissional</label>
                    <input type="text" name="name" value="{{ old('name', $professional->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Negócio</label>
                    <input type="text" name="business_name" value="{{ old('business_name', $professional->business_name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $professional->email) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                    <input type="text" name="phone" value="{{ old('phone', $professional->phone) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Biografia/Descrição</label>
                    <textarea name="bio" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('bio', $professional->bio) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Esta descrição aparecerá na sua página pública</p>
                </div>
            </div>
        </div>

        <!-- Personalização -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Personalização</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                    @if($professional->logo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $professional->logo) }}" alt="Logo" class="w-20 h-20 object-cover rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG ou GIF. Máximo 2MB.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cor da Marca</label>
                    <div class="flex items-center space-x-3">
                        <input type="color" name="brand_color" value="{{ old('brand_color', $professional->brand_color) }}" class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer">
                        <span class="text-sm text-gray-600">{{ $professional->brand_color }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Esta cor será usada na sua página pública</p>
                </div>
            </div>
        </div>

        <!-- Link Público -->
        <div class="bg-purple-50 rounded-lg border border-purple-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Seu Link de Agendamento</h3>
            <p class="text-sm text-gray-600 mb-4">Compartilhe este link com seus clientes para que eles possam agendar online:</p>
            <div class="flex items-center space-x-2">
                <input type="text" value="{{ url('/' . $professional->slug) }}" readonly class="flex-1 px-4 py-2 bg-white border border-purple-300 rounded-lg text-purple-800 font-medium">
                <button type="button" onclick="navigator.clipboard.writeText('{{ url('/' . $professional->slug) }}')" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    Copiar
                </button>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('panel.dashboard') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                Salvar Alterações
            </button>
        </div>
    </form>
</div>
@endsection

