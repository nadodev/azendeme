<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - Blog AzendaMe</title>
    <meta name="description" content="Posts da categoria {{ $category->name }}">
    @vite(['resources/css/app.css'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-purple-600">AzendaMe</a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="/" class="text-gray-700 hover:text-purple-600 transition">Início</a>
                    <a href="/blog" class="text-purple-600 font-medium">Blog</a>
                    <a href="/funcionalidades" class="text-gray-700 hover:text-purple-600 transition">Funcionalidades</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="/" class="text-gray-500 hover:text-gray-700">Início</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li>
                        <a href="{{ route('blog.index', $professional->slug) }}" class="text-gray-500 hover:text-gray-700">Blog</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                    <li>
                        <span class="text-gray-900 font-medium">{{ $category->name }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Category Header -->
    <section class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center mb-4">
                <span class="inline-block w-6 h-6 rounded-full mr-3" 
                      style="background-color: {{ $category->color }}"></span>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $category->name }}</h1>
            </div>
            @if($category->description)
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $category->description }}</p>
            @endif
        </div>
    </section>

    <!-- Posts -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                        @if($post->featured_image)
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" 
                                     class="w-full h-48 object-cover">
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-3">
                                <a href="{{ route('blog.show', [$professional->slug, $post->slug]) }}" 
                                   class="hover:text-purple-600 transition">
                                    {{ $post->title }}
                                </a>
                            </h2>

                            @if($post->excerpt)
                                <p class="text-gray-600 mb-4">{{ Str::limit($post->excerpt, 120) }}</p>
                            @endif

                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ $post->published_at->format('d/m/Y') }}</span>
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ $post->views_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum post encontrado</h3>
                <p class="mt-1 text-sm text-gray-500">Esta categoria ainda não possui posts publicados.</p>
                <div class="mt-6">
                    <a href="{{ route('blog.index', $professional->slug) }}" class="text-purple-600 hover:text-purple-700 font-medium">
                        ← Voltar ao blog
                    </a>
                </div>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} AzendaMe - Sistema de Agendamentos</p>
            </div>
        </div>
    </footer>
</body>
</html>
