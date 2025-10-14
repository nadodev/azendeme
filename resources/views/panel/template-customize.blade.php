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

    <!-- Template Info -->
    <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    Template: {{ ucfirst($templateInfo['name']) }}
                </h3>
                <p class="text-gray-600">{{ $templateInfo['description'] }}</p>
            </div>
            <div class="text-right">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Ativo
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('panel.template.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Cores por Seção -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                Cores por Seção
            </h3>
            
            <!-- Seção Hero -->
            <div class="mb-8 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Seção Principal (Hero)
                </h4>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor Principal</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="hero_primary_color" value="{{ old('hero_primary_color', $professional->templateSetting->hero_primary_color ?? '#2563EB') }}" class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ old('hero_primary_color', $professional->templateSetting->hero_primary_color ?? '#2563EB') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Botões e destaques</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor de Fundo</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="hero_background_color" value="{{ old('hero_background_color', $professional->templateSetting->hero_background_color ?? '#F1F5F9') }}" class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ old('hero_background_color', $professional->templateSetting->hero_background_color ?? '#F1F5F9') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Fundo da seção</p>
                    </div>
                </div>
            </div>

            <!-- Seção Serviços -->
            <div class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Seção de Serviços
                </h4>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor Principal</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="services_primary_color" value="{{ old('services_primary_color', $professional->templateSetting->services_primary_color ?? '#10B981') }}" class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ old('services_primary_color', $professional->templateSetting->services_primary_color ?? '#10B981') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Ícones e destaques</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor de Fundo</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="services_background_color" value="{{ old('services_background_color', $professional->templateSetting->services_background_color ?? '#FFFFFF') }}" class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ old('services_background_color', $professional->templateSetting->services_background_color ?? '#FFFFFF') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Fundo dos cards</p>
                    </div>
                </div>
            </div>

            <!-- Seção Galeria -->
            <div class="mb-8 p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border border-pink-200">
                <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Seção de Galeria
                </h4>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor Principal</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="gallery_primary_color" value="{{ old('gallery_primary_color', $professional->templateSetting->gallery_primary_color ?? '#EC4899') }}" class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ old('gallery_primary_color', $professional->templateSetting->gallery_primary_color ?? '#EC4899') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Overlay e efeitos</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor de Fundo</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="gallery_background_color" value="{{ old('gallery_background_color', $professional->templateSetting->gallery_background_color ?? '#F9FAFB') }}" class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ old('gallery_background_color', $professional->templateSetting->gallery_background_color ?? '#F9FAFB') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Fundo da seção</p>
                    </div>
                </div>
            </div>

            <!-- Seção Agendamento -->
            <div class="mb-8 p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border border-purple-200">
                <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Seção de Agendamento
                </h4>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor Principal</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="booking_primary_color" value="{{ old('booking_primary_color', $professional->templateSetting->booking_primary_color ?? '#7C3AED') }}" class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ old('booking_primary_color', $professional->templateSetting->booking_primary_color ?? '#7C3AED') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Botões e seleções</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor de Fundo</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="booking_background_color" value="{{ old('booking_background_color', $professional->templateSetting->booking_background_color ?? '#F3F4F6') }}" class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ old('booking_background_color', $professional->templateSetting->booking_background_color ?? '#F3F4F6') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Fundo do formulário</p>
                    </div>
                </div>
            </div>

            <!-- Cores Globais -->
            <div class="p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg border border-gray-200">
                <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                    </svg>
                    Cores Globais
                </h4>
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor do Texto</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="text_color" value="{{ old('text_color', $professional->templateSetting->text_color ?? '#1F2937') }}" class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ old('text_color', $professional->templateSetting->text_color ?? '#1F2937') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Texto principal</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor de Destaque</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="accent_color" value="{{ old('accent_color', $professional->templateSetting->accent_color ?? '#7C3AED') }}" class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ old('accent_color', $professional->templateSetting->accent_color ?? '#7C3AED') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Links e hover</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor de Fundo Geral</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="background_color" value="{{ old('background_color', $professional->templateSetting->background_color ?? '#FFFFFF') }}" class="w-12 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" value="{{ old('background_color', $professional->templateSetting->background_color ?? '#FFFFFF') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Fundo do site</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imagens -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Imagens
            </h3>

            <!-- Imagem da Seção Sobre Nós -->
            <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Seção Sobre Nós
                </h4>
                
                <div class="space-y-4">
                    <!-- Imagem atual -->
                    @if($professional->templateSetting && $professional->templateSetting->about_image)
                        <div class="flex items-center space-x-4 p-4 bg-white rounded-lg border border-gray-200">
                            <img src="{{ asset('storage/' . $professional->templateSetting->about_image) }}" 
                                 alt="Imagem atual" 
                                 class="w-20 h-20 object-cover rounded-lg">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Imagem atual da seção Sobre Nós</p>
                                <p class="text-xs text-gray-500">Esta imagem será exibida na seção "Sobre Nós" da página pública</p>
                            </div>
                            <label class="flex items-center space-x-2 text-red-600 hover:text-red-800 cursor-pointer">
                                <input type="checkbox" name="remove_about_image" value="1" class="rounded">
                                <span class="text-sm">Remover</span>
                            </label>
                        </div>
                    @endif

                    <!-- Upload de nova imagem -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $professional->templateSetting && $professional->templateSetting->about_image ? 'Alterar Imagem' : 'Adicionar Imagem' }}
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="about_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload de arquivo</span>
                                        <input id="about_image" name="about_image" type="file" class="sr-only" accept="image/*" onchange="previewAboutImage(this)">
                                    </label>
                                    <p class="pl-1">ou arraste e solte</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF até 10MB</p>
                            </div>
                        </div>
                        <div id="about-image-preview" class="mt-4 hidden">
                            <img id="about-image-preview-img" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg mx-auto">
                        </div>
                    </div>
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
            <div class="flex items-center gap-4">
                <a href="{{ route('panel.configuracoes.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="button" onclick="resetToDefaults()" class="px-6 py-3 border border-orange-300 text-orange-700 font-semibold rounded-lg hover:bg-orange-50 transition">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Resetar Cores
                </button>
            </div>
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

// Função para preview da imagem da seção Sobre Nós
function previewAboutImage(input) {
    const preview = document.getElementById('about-image-preview');
    const previewImg = document.getElementById('about-image-preview-img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}

// Função para resetar cores para valores padrão do template
function resetToDefaults() {
    if (confirm('Tem certeza que deseja resetar todas as cores para os valores padrão do template {{ $templateInfo["name"] }}? Esta ação não pode ser desfeita.')) {
        // Cores padrão específicas do template
        const templateDefaults = {
                    @if($templateInfo['name'] === 'barber')
                        // Template Barber - Tons dourados sobre fundo escuro
                        'hero_primary_color': '#D4AF37',
                        'hero_background_color': '#0F0F10',
                        'services_primary_color': '#D4AF37',
                        'services_background_color': '#1A1A1D',
                        'gallery_primary_color': '#D4AF37',
                        'gallery_background_color': '#0F0F10',
                        'booking_primary_color': '#D4AF37',
                        'booking_background_color': '#1A1A1D',
                        'text_color': '#FFFFFF',
                        'accent_color': '#B8860B',
                        'background_color': '#0F0F10'
            @elseif($templateInfo['name'] === 'tattoo')
                // Template Tattoo - Tons roxos sobre fundo escuro
                'hero_primary_color': '#8B5CF6',
                'hero_background_color': '#0F0F10',
                'services_primary_color': '#A78BFA',
                'services_background_color': '#1A1520',
                'gallery_primary_color': '#8B5CF6',
                'gallery_background_color': '#0F0F10',
                'booking_primary_color': '#7C3AED',
                'booking_background_color': '#1A1520',
                'text_color': '#FFFFFF',
                'accent_color': '#7C3AED',
                'background_color': '#0F0F10'
            @elseif($templateInfo['name'] === 'salon')
                // Template Salon - Tons de rosa bem suave sobre fundo claro
                'hero_primary_color': '#F472B6',
                'hero_background_color': '#FEF7FF',
                'services_primary_color': '#EC4899',
                'services_background_color': '#FFFFFF',
                'gallery_primary_color': '#F472B6',
                'gallery_background_color': '#FEF7FF',
                'booking_primary_color': '#EC4899',
                'booking_background_color': '#FDF2F8',
                'text_color': '#4B5563',
                'accent_color': '#EC4899',
                'background_color': '#FFFFFF'
            @else
                // Template Clinic - Tons azuis e verdes sobre fundo claro
                'hero_primary_color': '#2563EB',
                'hero_background_color': '#F1F5F9',
                'services_primary_color': '#059669',
                'services_background_color': '#FFFFFF',
                'gallery_primary_color': '#DC2626',
                'gallery_background_color': '#FEF2F2',
                'booking_primary_color': '#7C3AED',
                'booking_background_color': '#F8FAFC',
                'text_color': '#1F2937',
                'accent_color': '#7C3AED',
                'background_color': '#FFFFFF'
            @endif
        };
        
        // Aplicar cores padrão
        Object.entries(templateDefaults).forEach(([name, value]) => {
            const colorInput = document.querySelector(`input[name="${name}"]`);
            const textInput = colorInput?.nextElementSibling?.nextElementSibling;
            
            if (colorInput) {
                colorInput.value = value;
                if (textInput) {
                    textInput.value = value.toUpperCase();
                }
            }
        });
        
        // Mostrar mensagem de sucesso
        alert('Cores resetadas para os valores padrão do template {{ $templateInfo["name"] }}! Clique em "Salvar Personalizações" para aplicar as mudanças.');
    }
}
</script>
@endsection

