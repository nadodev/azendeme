@extends('panel.layout')

@section('title', 'Selecionar Template')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Escolha seu Template</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Selecione um template que combine com o estilo do seu negócio</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Templates por Categoria -->
        <div class="space-y-12">
            @foreach($categories as $key => $category)
            <div class="template-category">
                <!-- Cabeçalho da Categoria -->
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-4xl">{{ $category['icon'] }}</span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $category['name'] }}</h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400">{{ $category['description'] }}</p>
                </div>

                <!-- Cards de Templates da Categoria -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($category['templates'] as $template)
                    <div class="template-card group relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border-2 transition-all duration-300 hover:shadow-2xl hover:scale-105 {{ $professional->template === $template ? 'border-blue-500 ring-4 ring-blue-200' : 'border-transparent' }}">
                        <!-- Preview do Template -->
                        <div class="aspect-video relative overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                            <!-- Simulação visual baseada nas cores da categoria -->
                            <div class="absolute inset-0 p-4" style="background: linear-gradient(135deg, {{ $category['colors']['hero_bg'] }} 0%, {{ $category['colors']['background'] }} 100%);">
                                <div class="h-full flex flex-col justify-between">
                                    <div class="space-y-2">
                                        <div class="h-3 rounded" style="background: {{ $category['colors']['primary'] }}; width: 60%;"></div>
                                        <div class="h-2 rounded bg-gray-300 dark:bg-gray-600" style="width: 40%;"></div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <div class="h-16 rounded" style="background: {{ $category['colors']['services_bg'] }}; border: 1px solid {{ $category['colors']['primary'] }}20;"></div>
                                        <div class="h-16 rounded" style="background: {{ $category['colors']['services_bg'] }}; border: 1px solid {{ $category['colors']['primary'] }}20;"></div>
                                        <div class="h-16 rounded" style="background: {{ $category['colors']['services_bg'] }}; border: 1px solid {{ $category['colors']['primary'] }}20;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Badge do template ativo -->
                            @if($professional->template === $template)
                            <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Ativo
                            </div>
                            @endif
                        </div>

                        <!-- Informações do Template -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 capitalize">
                                {{ str_replace(['-', '_'], ' ', $template) }}
                            </h3>
                            
                            <!-- Paleta de Cores -->
                            <div class="flex gap-2 mb-4">
                                <div class="w-8 h-8 rounded-full shadow-md" style="background: {{ $category['colors']['primary'] }}"></div>
                                <div class="w-8 h-8 rounded-full shadow-md" style="background: {{ $category['colors']['secondary'] }}"></div>
                                <div class="w-8 h-8 rounded-full shadow-md" style="background: {{ $category['colors']['accent'] }}"></div>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="flex gap-2">
                                @if($professional->template === $template)
                                    <button disabled class="flex-1 bg-gray-200 text-gray-500 px-4 py-2 rounded-lg font-semibold cursor-not-allowed">
                                        Em Uso
                                    </button>
                                @else
                                    <form action="{{ route('panel.template.apply') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="template" value="{{ $template }}">
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                            Aplicar Template
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('public.show', $professional->slug) }}?preview_template={{ $template }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg font-semibold transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Botão para Personalizar Cores -->
        <div class="mt-12 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                🎨 Personalize as Cores do Seu Template
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">
                Após aplicar um template, você pode personalizar todas as cores para combinar perfeitamente com a identidade visual do seu negócio.
            </p>
            <a href="{{ route('panel.template.customize') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                Personalizar Cores
            </a>
        </div>
    </div>
</div>

<style>
    .template-category:not(:last-child) {
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 3rem;
    }
    
    .dark .template-category:not(:last-child) {
        border-bottom-color: #374151;
    }
</style>
@endsection

