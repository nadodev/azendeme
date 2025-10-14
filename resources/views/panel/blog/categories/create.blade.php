@extends('panel.layout')

@section('page-title', 'Criar Nova Categoria')
@section('page-subtitle', 'Adicione uma nova categoria para organizar seus posts')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ route('panel.blog.categories.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- Informações Básicas -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900">Informações da Categoria</h3>
                <p class="text-sm text-gray-500">Configure o nome, descrição e cor da categoria</p>
            </div>

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome da Categoria *
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: Tecnologia, Saúde, Beleza"
                           required>
                    @error('name')
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
                           value="{{ old('slug') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="tecnologia">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Descrição
                        <span class="text-gray-400">(opcional)</span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Breve descrição da categoria">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                        Cor da Categoria *
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="color" 
                               id="color" 
                               name="color" 
                               value="{{ old('color', '#3B82F6') }}"
                               class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer"
                               required>
                        <input type="text" 
                               id="color-text" 
                               value="{{ old('color', '#3B82F6') }}"
                               class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="#3B82F6">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Escolha uma cor para identificar esta categoria</p>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Ordem de Exibição
                        <span class="text-gray-400">(opcional)</span>
                    </label>
                    <input type="number" 
                           id="sort_order" 
                           name="sort_order" 
                           value="{{ old('sort_order', 0) }}"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0">
                    <p class="mt-1 text-sm text-gray-500">Números menores aparecem primeiro na listagem</p>
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" 
                           id="active" 
                           name="active" 
                           value="1"
                           {{ old('active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="active" class="ml-2 text-sm text-gray-700">
                        Categoria ativa (visível para seleção em posts)
                    </label>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-900">Preview</h3>
                <p class="text-sm text-gray-500">Como a categoria aparecerá na interface</p>
            </div>

            <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                <div id="preview-color" class="w-4 h-4 rounded-full" style="background-color: {{ old('color', '#3B82F6') }}"></div>
                <span id="preview-name" class="font-medium text-gray-900">{{ old('name', 'Nome da Categoria') }}</span>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Ativa
                </span>
            </div>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('panel.blog.categories.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Criar Categoria
            </button>
        </div>
    </form>
</div>

<script>
// Sincronizar cor entre color picker e input de texto
const colorPicker = document.getElementById('color');
const colorText = document.getElementById('color-text');
const previewColor = document.getElementById('preview-color');

function updateColor() {
    const color = colorPicker.value;
    colorText.value = color;
    previewColor.style.backgroundColor = color;
}

colorPicker.addEventListener('input', updateColor);
colorText.addEventListener('input', function() {
    if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
        colorPicker.value = this.value;
        previewColor.style.backgroundColor = this.value;
    }
});

// Gerar slug automaticamente
document.getElementById('name').addEventListener('input', function() {
    const slug = document.getElementById('slug');
    if (!slug.value) {
        const name = this.value
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slug.value = name;
    }
    
    // Atualizar preview
    document.getElementById('preview-name').textContent = this.value || 'Nome da Categoria';
});

// Atualizar preview do status
document.getElementById('active').addEventListener('change', function() {
    const statusElement = document.querySelector('#preview-color').nextElementSibling.nextElementSibling;
    if (this.checked) {
        statusElement.textContent = 'Ativa';
        statusElement.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800';
    } else {
        statusElement.textContent = 'Inativa';
        statusElement.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
    }
});
</script>
@endsection
