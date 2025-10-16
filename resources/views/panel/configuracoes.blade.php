@extends('panel.layout')

@section('page-title', 'Configurações')
@section('page-subtitle', 'Personalize seu perfil e preferências')

@section('content')
<div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Botão para Selecionar Template por Categoria -->
    <a href="{{ route('panel.template.select') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 p-1 transition-all hover:shadow-2xl hover:scale-105">
        <div class="bg-white rounded-lg p-4 h-full transition-all group-hover:bg-opacity-95">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-gradient-to-br from-blue-100 to-purple-100 rounded-lg">
                    <span class="text-2xl">🎨</span>
                </div>
                <h3 class="font-bold text-gray-900">Escolher Template</h3>
            </div>
            <p class="text-sm text-gray-600">Navegue por categorias e escolha o template ideal para seu negócio</p>
        </div>
    </a>

    <!-- Botão para Personalizar Cores -->
    <a href="{{ route('panel.template.customize') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-purple-600 to-pink-600 p-1 transition-all hover:shadow-2xl hover:scale-105">
        <div class="bg-white rounded-lg p-4 h-full transition-all group-hover:bg-opacity-95">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900">Personalizar Cores</h3>
            </div>
            <p class="text-sm text-gray-600">Ajuste cores e personalize cada detalhe do seu template atual</p>
        </div>
    </a>
</div>

<div class="max-w-3xl mx-auto">
    <form method="POST" action="{{ route('panel.configuracoes.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Informações do Negócio -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 lg:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 lg:mb-6">Informações do Negócio</h3>
            
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
                    <input type="email" value="{{ $professional->email }}" readonly class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                    <p class="text-xs text-gray-500 mt-1">O e-mail não pode ser alterado por questões de segurança</p>
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

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Template da Página (Seleção Rápida)</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div class="relative">
                            <input type="radio" name="template" value="clinic" id="template-clinic" {{ old('template', $professional->template) == 'clinic' ? 'checked' : '' }} class="peer hidden">
                            <label for="template-clinic" class="block p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl mb-1">🏥</span>
                                    <span class="font-semibold text-sm">Clínica</span>
                                </div>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="radio" name="template" value="salon" id="template-salon" {{ old('template', $professional->template) == 'salon' ? 'checked' : '' }} class="peer hidden">
                            <label for="template-salon" class="block p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-pink-500 peer-checked:border-pink-600 peer-checked:bg-pink-50 transition">
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl mb-1">💇</span>
                                    <span class="font-semibold text-sm">Salão</span>
                                </div>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="radio" name="template" value="tattoo" id="template-tattoo" {{ old('template', $professional->template) == 'tattoo' ? 'checked' : '' }} class="peer hidden">
                            <label for="template-tattoo" class="block p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-500 peer-checked:border-red-600 peer-checked:bg-red-50 transition">
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl mb-1">🎨</span>
                                    <span class="font-semibold text-sm">Tattoo</span>
                                </div>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="radio" name="template" value="barber" id="template-barber" {{ old('template', $professional->template) == 'barber' ? 'checked' : '' }} class="peer hidden">
                            <label for="template-barber" class="block p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-amber-600 peer-checked:border-amber-700 peer-checked:bg-amber-50 transition">
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl mb-1">✂️</span>
                                    <span class="font-semibold text-sm">Barbearia</span>
                                </div>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="radio" name="template" value="spa" id="template-spa" {{ old('template', $professional->template) == 'spa' ? 'checked' : '' }} class="peer hidden">
                            <label for="template-spa" class="block p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 peer-checked:border-green-600 peer-checked:bg-green-50 transition">
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl mb-1">🧘</span>
                                    <span class="font-semibold text-sm">Spa</span>
                                </div>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="radio" name="template" value="gym" id="template-gym" {{ old('template', $professional->template) == 'gym' ? 'checked' : '' }} class="peer hidden">
                            <label for="template-gym" class="block p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-orange-500 peer-checked:border-orange-600 peer-checked:bg-orange-50 transition">
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl mb-1">💪</span>
                                    <span class="font-semibold text-sm">Academia</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-xs text-blue-800">
                            💡 <strong>Dica:</strong> Para ver todos os templates com preview e cores detalhadas, 
                            <a href="{{ route('panel.template.select') }}" class="underline font-semibold hover:text-blue-900">clique aqui</a>
                        </p>
                    </div>
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

