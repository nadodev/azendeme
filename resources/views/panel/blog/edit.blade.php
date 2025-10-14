@extends('panel.layout')

@section('page-title', 'Editar Post')
@section('page-subtitle', 'Edite as informações do post')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('panel.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Informações Básicas -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900">Informações Básicas</h3>
                <p class="text-sm text-gray-500">Configure o título, slug e status do post</p>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título do Post *
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $post->title) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Digite o título do post"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        Slug (URL)
                        <span class="text-gray-400">(opcional - será gerado automaticamente)</span>
                    </label>
                    <input type="text" 
                           id="slug" 
                           name="slug" 
                           value="{{ old('slug', $post->slug) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="url-do-post">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                        Resumo
                        <span class="text-gray-400">(aparece na listagem e preview)</span>
                    </label>
                    <textarea id="excerpt" 
                              name="excerpt" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Breve descrição do post">{{ old('excerpt', $post->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Categoria
                        </label>
                        <select id="category_id" 
                                name="category_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Selecione uma categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status *
                        </label>
                        <select id="status" 
                                name="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Rascunho</option>
                            <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Publicado</option>
                            <option value="scheduled" {{ old('status', $post->status) == 'scheduled' ? 'selected' : '' }}>Agendado</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div id="scheduled-date" class="{{ old('status', $post->status) == 'scheduled' ? '' : 'hidden' }}">
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                        Data de Publicação
                    </label>
                    <input type="datetime-local" 
                           id="published_at" 
                           name="published_at" 
                           value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('published_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Conteúdo -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900">Conteúdo do Post</h3>
                <p class="text-sm text-gray-500">Escreva o conteúdo principal do seu post</p>
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Conteúdo *
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="15"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Escreva o conteúdo do seu post aqui..."
                          required>{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Tags -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900">Tags</h3>
                <p class="text-sm text-gray-500">Selecione as tags relacionadas ao post</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($tags as $tag)
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="tags[]" 
                               value="{{ $tag->id }}"
                               {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('tags')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Configurações Adicionais -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900">Configurações Adicionais</h3>
                <p class="text-sm text-gray-500">Configure opções extras para o post</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Imagem de Destaque
                    </label>
                    
                    <!-- Upload de arquivo -->
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Fazer upload de uma imagem</span>
                                    <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                </label>
                                <p class="pl-1">ou arraste e solte</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF até 10MB</p>
                        </div>
                    </div>
                    
                    <!-- Preview da imagem atual -->
                    @if($post->featured_image)
                        <div id="current-image" class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Imagem atual:</p>
                            <div class="relative inline-block">
                                <img src="{{ $post->featured_image }}" alt="Imagem atual" class="h-32 w-32 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="removeCurrentImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                    ×
                                </button>
                            </div>
                            <input type="hidden" name="current_image" value="{{ $post->featured_image }}">
                        </div>
                    @endif
                    
                    <!-- Preview da nova imagem -->
                    <div id="image-preview" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 mb-2">Nova imagem:</p>
                        <div class="relative inline-block">
                            <img id="preview" src="" alt="Preview" class="h-32 w-32 object-cover rounded-lg border border-gray-200">
                            <button type="button" onclick="removeImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                ×
                            </button>
                        </div>
                    </div>
                    
                    @error('featured_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="featured" 
                               value="1"
                               {{ old('featured', $post->featured) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Post em Destaque</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="allow_comments" 
                               value="1"
                               {{ old('allow_comments', $post->allow_comments) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Permitir Comentários</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('panel.blog.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Atualizar Post
            </button>
        </div>
    </form>
</div>

<script>
// Mostrar/ocultar campo de data agendada
document.getElementById('status').addEventListener('change', function() {
    const scheduledDate = document.getElementById('scheduled-date');
    if (this.value === 'scheduled') {
        scheduledDate.classList.remove('hidden');
    } else {
        scheduledDate.classList.add('hidden');
    }
});

// Gerar slug automaticamente
document.getElementById('title').addEventListener('input', function() {
    const slug = document.getElementById('slug');
    if (!slug.value) {
        const title = this.value
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slug.value = title;
    }
});

// Preview de imagem
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Remover nova imagem
function removeImage() {
    document.getElementById('featured_image').value = '';
    document.getElementById('image-preview').classList.add('hidden');
    document.getElementById('preview').src = '';
}

// Remover imagem atual
function removeCurrentImage() {
    document.getElementById('current-image').classList.add('hidden');
    // Adicionar um campo hidden para indicar que a imagem atual deve ser removida
    const removeInput = document.createElement('input');
    removeInput.type = 'hidden';
    removeInput.name = 'remove_current_image';
    removeInput.value = '1';
    document.querySelector('form').appendChild(removeInput);
}
</script>
@endsection
