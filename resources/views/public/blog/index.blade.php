<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - AzendaMe</title>
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
                    <a href="{{ $publicUrl }}" class="text-gray-700 hover:text-purple-600 transition">Início</a>
                    <a href="/blog" class="text-purple-600 font-medium">Blog</a>
                    <a href="/funcionalidades" class="text-gray-700 hover:text-purple-600 transition">Funcionalidades</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-purple-600 to-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Blog</h1>
            <p class="text-xl text-purple-100 max-w-2xl mx-auto">
                Dicas, novidades e insights sobre gestão de agendamentos e atendimento ao cliente
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Search -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Buscar</h3>
                    <form method="GET" action="{{ route('blog.index', $professional->slug) }}">
                        <div class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Digite sua busca..." 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-r-md hover:bg-purple-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Categorias</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('blog.index', $professional->slug) }}" 
                               class="text-gray-600 hover:text-purple-600 transition {{ !request('category') ? 'text-purple-600 font-medium' : '' }}">
                                Todas as categorias
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('blog.index', [$professional->slug, 'category' => $category->id]) }}" 
                                   class="text-gray-600 hover:text-purple-600 transition {{ request('category') == $category->id ? 'text-purple-600 font-medium' : '' }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tags -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('blog.index', [$professional->slug, 'tag' => $tag->id]) }}" 
                               class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full hover:bg-purple-100 hover:text-purple-700 transition {{ request('tag') == $tag->id ? 'bg-purple-100 text-purple-700' : '' }}">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>

            <!-- Posts -->
            <div class="lg:col-span-3">
                @if($featuredPosts->count() > 0)
                    <!-- Posts em Destaque -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Posts em Destaque
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($featuredPosts as $post)
                                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border-2 border-yellow-200">
                                    @if($post->featured_image)
                                        <div class="aspect-w-16 aspect-h-9 relative">
                                            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" 
                                                 class="w-full h-48 object-cover">
                                            <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                                ⭐ Destaque
                                            </div>
                                        </div>
                                    @else
                                        <div class="h-48 bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center">
                                            <div class="text-center text-white">
                                                <svg class="w-12 h-12 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                <div class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold inline-block">
                                                    ⭐ Destaque
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="p-6">
                                        @if($post->category)
                                            <div class="flex items-center mb-3">
                                                <span class="inline-block w-3 h-3 rounded-full mr-2" 
                                                      style="background-color: {{ $post->category->color }}"></span>
                                                <a href="{{ route('blog.category', [$professional->slug, $post->category->slug]) }}" 
                                                   class="text-sm text-gray-600 hover:text-purple-600 transition">
                                                    {{ $post->category->name }}
                                                </a>
                                            </div>
                                        @endif

                                        <h3 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2">
                                            <a href="{{ route('blog.show', [$professional->slug, $post->slug]) }}" 
                                               class="hover:text-purple-600 transition">
                                                {{ $post->title }}
                                            </a>
                                        </h3>

                                        @if($post->excerpt)
                                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                        @endif

                                        <div class="flex items-center justify-between text-sm text-gray-500">
                                            <span>{{ $post->published_at->format('d/m/Y') }}</span>
                                            <a href="{{ route('blog.show', [$professional->slug, $post->slug]) }}" 
                                               class="text-purple-600 hover:text-purple-700 font-medium">
                                                Ler mais →
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($posts->count() > 0)
                    <!-- Todos os Posts -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Todos os Posts</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($posts as $post)
                            <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                @if($post->featured_image)
                                    <div class="aspect-w-16 aspect-h-9">
                                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" 
                                             class="w-full h-48 object-cover">
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    @if($post->category)
                                        <div class="flex items-center mb-3">
                                            <span class="inline-block w-3 h-3 rounded-full mr-2" 
                                                  style="background-color: {{ $post->category->color }}"></span>
                                            <a href="{{ route('blog.category', [$professional->slug, $post->category->slug]) }}" 
                                               class="text-sm text-gray-600 hover:text-purple-600 transition">
                                                {{ $post->category->name }}
                                            </a>
                                        </div>
                                    @endif

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
                        <p class="mt-1 text-sm text-gray-500">
                            @if(request('search') || request('category') || request('tag'))
                                Tente ajustar os filtros de busca.
                            @else
                                Ainda não há posts publicados.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} AzendaMe - Sistema de Agendamentos</p>
            </div>
        </div>
    </footer>
</body>
</html>
