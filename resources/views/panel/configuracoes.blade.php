@extends('panel.layout')

@section('page-title', 'Configurações')
@section('page-subtitle', 'Personalize seu perfil e preferências')

@section('content')
<div class="mb-6">
    <a href="{{ route('panel.template.customize') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
        </svg>
        Personalizar Cores & Textos do Template
    </a>
</div>

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

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Template da Página</label>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="relative">
                            <input type="radio" name="template" value="clinic" id="template-clinic" {{ old('template', $professional->template) == 'clinic' ? 'checked' : '' }} class="peer hidden">
                            <label for="template-clinic" class="block p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 peer-checked:border-purple-600 peer-checked:bg-purple-50 transition">
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 mb-2 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-sm">Clínica</span>
                                    <span class="text-xs text-gray-500 text-center mt-1">Design limpo e profissional</span>
                                </div>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="radio" name="template" value="salon" id="template-salon" {{ old('template', $professional->template) == 'salon' ? 'checked' : '' }} class="peer hidden">
                            <label for="template-salon" class="block p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 peer-checked:border-purple-600 peer-checked:bg-purple-50 transition">
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 mb-2 bg-gradient-to-br from-pink-100 to-purple-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-sm">Salão/Spa</span>
                                    <span class="text-xs text-gray-500 text-center mt-1">Elegante e luxuoso</span>
                                </div>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="radio" name="template" value="tattoo" id="template-tattoo" {{ old('template', $professional->template) == 'tattoo' ? 'checked' : '' }} class="peer hidden">
                            <label for="template-tattoo" class="block p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 peer-checked:border-purple-600 peer-checked:bg-purple-50 transition">
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 mb-2 bg-gradient-to-br from-gray-800 to-gray-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-sm">Tattoo/Arte</span>
                                    <span class="text-xs text-gray-500 text-center mt-1">Ousado e artístico</span>
                                </div>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="radio" name="template" value="barber" id="template-barber" {{ old('template', $professional->template) == 'barber' ? 'checked' : '' }} class="peer hidden">
                            <label for="template-barber" class="block p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 peer-checked:border-purple-600 peer-checked:bg-purple-50 transition">
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 mb-2 bg-gradient-to-br from-amber-700 to-amber-900 rounded-lg flex items-center justify-center">
                                        <span class="text-2xl">💈</span>
                                    </div>
                                    <span class="font-semibold text-sm">Barbearia</span>
                                    <span class="text-xs text-gray-500 text-center mt-1">Clássico e masculino</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Escolha o estilo visual que melhor representa seu negócio</p>
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

