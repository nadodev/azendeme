@extends('panel.layout')

@section('page-title', 'Personalizar Template')
@section('page-subtitle', 'Customize cores e textos da sua página pública')

@section('content')
<div class="max-w-5xl">
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('panel.configuracoes.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar para Configurações
        </a>
    </div>

    <form method="POST" action="{{ route('panel.template.update') }}" class="space-y-6">
        @csrf

        <!-- Cores do Template -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                Paleta de Cores
            </h3>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cor Primária</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="primary_color" value="{{ old('primary_color', $professional->templateSetting->primary_color ?? '#8B5CF6') }}" class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" value="{{ old('primary_color', $professional->templateSetting->primary_color ?? '#8B5CF6') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Cor principal do template</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cor Secundária</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="secondary_color" value="{{ old('secondary_color', $professional->templateSetting->secondary_color ?? '#A78BFA') }}" class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" value="{{ old('secondary_color', $professional->templateSetting->secondary_color ?? '#A78BFA') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Cor para destaques</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cor de Acento</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="accent_color" value="{{ old('accent_color', $professional->templateSetting->accent_color ?? '#7C3AED') }}" class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" value="{{ old('accent_color', $professional->templateSetting->accent_color ?? '#7C3AED') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Cor para botões e links</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cor de Fundo</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="background_color" value="{{ old('background_color', $professional->templateSetting->background_color ?? '#0F0F10') }}" class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" value="{{ old('background_color', $professional->templateSetting->background_color ?? '#0F0F10') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Cor de fundo do site</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cor do Texto</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="text_color" value="{{ old('text_color', $professional->templateSetting->text_color ?? '#F5F5F5') }}" class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" value="{{ old('text_color', $professional->templateSetting->text_color ?? '#F5F5F5') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Cor principal do texto</p>
                </div>
            </div>
        </div>

        <!-- Textos da Seção Hero -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Seção Principal (Hero)
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título Principal</label>
                    <input type="text" name="hero_title" value="{{ old('hero_title', $professional->templateSetting->hero_title ?? '') }}" placeholder="Ex: Bem-vindo à {{ $professional->business_name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Deixe vazio para usar o padrão</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subtítulo</label>
                    <textarea name="hero_subtitle" rows="3" placeholder="Descreva seu negócio em poucas palavras..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('hero_subtitle', $professional->templateSetting->hero_subtitle ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Badge/Etiqueta</label>
                    <input type="text" name="hero_badge" value="{{ old('hero_badge', $professional->templateSetting->hero_badge ?? '') }}" placeholder="Ex: Arte & Identidade" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Textos da Seção Serviços -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Seção de Serviços
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                    <input type="text" name="services_title" value="{{ old('services_title', $professional->templateSetting->services_title ?? '') }}" placeholder="Ex: Nossos Serviços" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subtítulo</label>
                    <textarea name="services_subtitle" rows="2" placeholder="Descrição dos seus serviços..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('services_subtitle', $professional->templateSetting->services_subtitle ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Textos da Seção Galeria -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Seção de Galeria
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                    <input type="text" name="gallery_title" value="{{ old('gallery_title', $professional->templateSetting->gallery_title ?? '') }}" placeholder="Ex: Galeria de Trabalhos" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subtítulo</label>
                    <textarea name="gallery_subtitle" rows="2" placeholder="Mostre seus melhores trabalhos..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('gallery_subtitle', $professional->templateSetting->gallery_subtitle ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Configurações Adicionais -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Configurações Adicionais
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Estilo dos Botões</label>
                    <div class="grid grid-cols-3 gap-4">
                        <label class="relative">
                            <input type="radio" name="button_style" value="rounded" {{ old('button_style', $professional->templateSetting->button_style ?? 'rounded') == 'rounded' ? 'checked' : '' }} class="peer hidden">
                            <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-purple-600 peer-checked:bg-purple-50 transition text-center">
                                <div class="font-semibold mb-1">Arredondado</div>
                                <div class="h-8 bg-purple-600 rounded-lg"></div>
                            </div>
                        </label>

                        <label class="relative">
                            <input type="radio" name="button_style" value="square" {{ old('button_style', $professional->templateSetting->button_style ?? 'rounded') == 'square' ? 'checked' : '' }} class="peer hidden">
                            <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-purple-600 peer-checked:bg-purple-50 transition text-center">
                                <div class="font-semibold mb-1">Quadrado</div>
                                <div class="h-8 bg-purple-600"></div>
                            </div>
                        </label>

                        <label class="relative">
                            <input type="radio" name="button_style" value="pill" {{ old('button_style', $professional->templateSetting->button_style ?? 'rounded') == 'pill' ? 'checked' : '' }} class="peer hidden">
                            <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-purple-600 peer-checked:bg-purple-50 transition text-center">
                                <div class="font-semibold mb-1">Pílula</div>
                                <div class="h-8 bg-purple-600 rounded-full"></div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <label class="font-medium text-gray-900">Mostrar Badge no Hero</label>
                        <p class="text-sm text-gray-500">Exibir etiqueta na seção principal</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="show_hero_badge" value="1" {{ old('show_hero_badge', $professional->templateSetting->show_hero_badge ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <label class="font-medium text-gray-900">Mostrar Divisores</label>
                        <p class="text-sm text-gray-500">Exibir linhas decorativas entre seções</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="show_dividers" value="1" {{ old('show_dividers', $professional->templateSetting->show_dividers ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="flex items-center justify-between">
            <a href="{{ route('panel.configuracoes.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg hover:shadow-xl">
                Salvar Personalizações
            </button>
        </div>
    </form>
</div>

<script>
// Sincronizar color picker com input de texto
document.querySelectorAll('input[type="color"]').forEach(colorInput => {
    const textInput = colorInput.nextElementSibling.nextElementSibling;
    
    colorInput.addEventListener('input', (e) => {
        textInput.value = e.target.value.toUpperCase();
    });
});
</script>
@endsection

