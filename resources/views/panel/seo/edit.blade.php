@extends('panel.layout')

@section('page-title', 'Configurar SEO - ' . ($pageTypes[$seoSetting->page_type] ?? $seoSetting->page_type))
@section('page-subtitle', 'Configure meta tags, Open Graph e outras configurações de SEO')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('panel.seo.update', $seoSetting->page_type) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Meta Tags Básicas -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900">Meta Tags Básicas</h3>
                <p class="text-sm text-gray-500">Configure as meta tags principais da página</p>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título da Página
                        <span class="text-gray-400">(máx. 60 caracteres)</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $seoSetting->title) }}"
                           maxlength="60"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Digite o título da página">
                    <div class="mt-1 text-sm text-gray-500">
                        <span id="title-count">0</span>/60 caracteres
                    </div>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Descrição da Página
                        <span class="text-gray-400">(máx. 160 caracteres)</span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              maxlength="160"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Digite a descrição da página">{{ old('description', $seoSetting->description) }}</textarea>
                    <div class="mt-1 text-sm text-gray-500">
                        <span id="description-count">0</span>/160 caracteres
                    </div>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="keywords" class="block text-sm font-medium text-gray-700 mb-2">
                        Palavras-chave
                        <span class="text-gray-400">(separadas por vírgula)</span>
                    </label>
                    <input type="text" 
                           id="keywords" 
                           name="keywords" 
                           value="{{ old('keywords', $seoSetting->keywords) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="palavra1, palavra2, palavra3">
                    @error('keywords')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Open Graph -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900">Open Graph (Facebook)</h3>
                <p class="text-sm text-gray-500">Configure como a página aparece quando compartilhada no Facebook</p>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="og_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título do Open Graph
                        <span class="text-gray-400">(máx. 60 caracteres)</span>
                    </label>
                    <input type="text" 
                           id="og_title" 
                           name="og_title" 
                           value="{{ old('og_title', $seoSetting->og_title) }}"
                           maxlength="60"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Deixe vazio para usar o título da página">
                    <div class="mt-1 text-sm text-gray-500">
                        <span id="og-title-count">0</span>/60 caracteres
                    </div>
                    @error('og_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="og_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Descrição do Open Graph
                        <span class="text-gray-400">(máx. 160 caracteres)</span>
                    </label>
                    <textarea id="og_description" 
                              name="og_description" 
                              rows="3"
                              maxlength="160"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Deixe vazio para usar a descrição da página">{{ old('og_description', $seoSetting->og_description) }}</textarea>
                    <div class="mt-1 text-sm text-gray-500">
                        <span id="og-description-count">0</span>/160 caracteres
                    </div>
                    @error('og_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="og_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Imagem do Open Graph
                        <span class="text-gray-400">(URL da imagem, recomendado: 1200x630px)</span>
                    </label>
                    <input type="url" 
                           id="og_image" 
                           name="og_image" 
                           value="{{ old('og_image', $seoSetting->og_image) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="https://exemplo.com/imagem.jpg">
                    @error('og_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Twitter Cards -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900">Twitter Cards</h3>
                <p class="text-sm text-gray-500">Configure como a página aparece quando compartilhada no Twitter</p>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="twitter_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título do Twitter
                        <span class="text-gray-400">(máx. 60 caracteres)</span>
                    </label>
                    <input type="text" 
                           id="twitter_title" 
                           name="twitter_title" 
                           value="{{ old('twitter_title', $seoSetting->twitter_title) }}"
                           maxlength="60"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Deixe vazio para usar o título da página">
                    <div class="mt-1 text-sm text-gray-500">
                        <span id="twitter-title-count">0</span>/60 caracteres
                    </div>
                    @error('twitter_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="twitter_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Descrição do Twitter
                        <span class="text-gray-400">(máx. 160 caracteres)</span>
                    </label>
                    <textarea id="twitter_description" 
                              name="twitter_description" 
                              rows="3"
                              maxlength="160"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Deixe vazio para usar a descrição da página">{{ old('twitter_description', $seoSetting->twitter_description) }}</textarea>
                    <div class="mt-1 text-sm text-gray-500">
                        <span id="twitter-description-count">0</span>/160 caracteres
                    </div>
                    @error('twitter_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="twitter_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Imagem do Twitter
                        <span class="text-gray-400">(URL da imagem, recomendado: 1200x630px)</span>
                    </label>
                    <input type="url" 
                           id="twitter_image" 
                           name="twitter_image" 
                           value="{{ old('twitter_image', $seoSetting->twitter_image) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="https://exemplo.com/imagem.jpg">
                    @error('twitter_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Configurações Avançadas -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900">Configurações Avançadas</h3>
                <p class="text-sm text-gray-500">Configurações adicionais de SEO</p>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="canonical_url" class="block text-sm font-medium text-gray-700 mb-2">
                        URL Canônica
                        <span class="text-gray-400">(URL oficial desta página)</span>
                    </label>
                    <input type="url" 
                           id="canonical_url" 
                           name="canonical_url" 
                           value="{{ old('canonical_url', $seoSetting->canonical_url) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="https://seusite.com/pagina">
                    @error('canonical_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="noindex" 
                               value="1"
                               {{ old('noindex', $seoSetting->noindex) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Noindex (não indexar no Google)</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="nofollow" 
                               value="1"
                               {{ old('nofollow', $seoSetting->nofollow) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Nofollow (não seguir links)</span>
                    </label>
                </div>

                <div>
                    <label for="custom_head" class="block text-sm font-medium text-gray-700 mb-2">
                        Código HTML Personalizado (Head)
                        <span class="text-gray-400">(será inserido no &lt;head&gt; da página)</span>
                    </label>
                    <textarea id="custom_head" 
                              name="custom_head" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                              placeholder="<!-- Scripts personalizados, meta tags adicionais, etc. -->">{{ old('custom_head', $seoSetting->custom_head) }}</textarea>
                    @error('custom_head')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="custom_footer" class="block text-sm font-medium text-gray-700 mb-2">
                        Código HTML Personalizado (Footer)
                        <span class="text-gray-400">(será inserido antes do &lt;/body&gt; da página)</span>
                    </label>
                    <textarea id="custom_footer" 
                              name="custom_footer" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                              placeholder="<!-- Scripts de tracking, analytics, etc. -->">{{ old('custom_footer', $seoSetting->custom_footer) }}</textarea>
                    @error('custom_footer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('panel.seo.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Salvar Configurações
            </button>
        </div>
    </form>
</div>

<script>
// Contadores de caracteres
function updateCharCount(inputId, countId, maxLength) {
    const input = document.getElementById(inputId);
    const count = document.getElementById(countId);
    
    if (input && count) {
        input.addEventListener('input', function() {
            const length = this.value.length;
            count.textContent = length;
            
            if (length > maxLength * 0.9) {
                count.classList.add('text-red-600');
                count.classList.remove('text-gray-500');
            } else {
                count.classList.remove('text-red-600');
                count.classList.add('text-gray-500');
            }
        });
        
        // Inicializar contador
        const initialLength = input.value.length;
        count.textContent = initialLength;
        if (initialLength > maxLength * 0.9) {
            count.classList.add('text-red-600');
            count.classList.remove('text-gray-500');
        }
    }
}

// Inicializar contadores
updateCharCount('title', 'title-count', 60);
updateCharCount('description', 'description-count', 160);
updateCharCount('og_title', 'og-title-count', 60);
updateCharCount('og_description', 'og-description-count', 160);
updateCharCount('twitter_title', 'twitter-title-count', 60);
updateCharCount('twitter_description', 'twitter-description-count', 160);
</script>
@endsection
