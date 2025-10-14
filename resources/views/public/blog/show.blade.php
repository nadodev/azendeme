<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Blog aZendame</title>
    <meta name="description" content="{{ $post->excerpt }}">
    @vite(['resources/css/app.css'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-purple-600">aZendame</a>
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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                        <span class="text-gray-900 font-medium">{{ $post->title }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <article class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Featured Image -->
            @if($post->featured_image)
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" 
                         class="w-full h-64 md:h-96 object-cover">
                </div>
            @endif

            <div class="p-8">
                <!-- Meta Information -->
                <div class="flex items-center mb-6">
                    @if($post->category)
                        <div class="flex items-center mr-6">
                            <span class="inline-block w-3 h-3 rounded-full mr-2" 
                                  style="background-color: {{ $post->category->color }}"></span>
                            <a href="{{ route('blog.category', [$professional->slug, $post->category->slug]) }}" 
                               class="text-sm text-gray-600 hover:text-purple-600 transition">
                                {{ $post->category->name }}
                            </a>
                        </div>
                    @endif
                    <span class="text-sm text-gray-500">{{ $post->published_at->format('d/m/Y') }}</span>
                    <span class="mx-2 text-gray-300">•</span>
                    <span class="text-sm text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ $post->views_count }} visualizações
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">{{ $post->title }}</h1>

                <!-- Excerpt -->
                @if($post->excerpt)
                    <div class="text-xl text-gray-600 mb-8 leading-relaxed">
                        {{ $post->excerpt }}
                    </div>
                @endif

                <!-- Content -->
                <div class="prose prose-lg max-w-none text-gray-700">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Tags:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('blog.tag', [$professional->slug, $tag->slug]) }}" 
                                   class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full hover:bg-purple-100 hover:text-purple-700 transition">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </article>

        <!-- Comments Section -->
        @if($post->allow_comments)
            <div class="mt-12 bg-white rounded-lg shadow-sm p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Comentários</h3>

                <!-- Comment Form -->
                <form method="POST" action="{{ route('blog.comment.store', [$professional->slug, $post->slug]) }}" class="mb-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="author_name" class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                            <input type="text" id="author_name" name="author_name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   value="{{ old('author_name') }}">
                            @error('author_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="author_email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" id="author_email" name="author_email" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   value="{{ old('author_email') }}">
                            @error('author_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Comentário *</label>
                        <textarea id="content" name="content" rows="4" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="Escreva seu comentário...">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition">
                        Enviar Comentário
                    </button>
                </form>

                <!-- Comments List -->
                @if($post->approvedComments->count() > 0)
                    <div class="space-y-6">
                        @foreach($post->approvedComments as $comment)
                            <div class="border-l-4 border-purple-200 pl-4">
                                <div class="flex items-center mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $comment->author_name }}</h4>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span class="text-sm text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <p class="text-gray-700">{{ $comment->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Seja o primeiro a comentar!</p>
                @endif
            </div>
        @endif

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Posts Relacionados</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $relatedPost)
                        <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                            @if($relatedPost->featured_image)
                                <div class="aspect-w-16 aspect-h-9">
                                    <img src="{{ $relatedPost->featured_image }}" alt="{{ $relatedPost->title }}" 
                                         class="w-full h-32 object-cover">
                                </div>
                            @endif
                            
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('blog.show', [$professional->slug, $relatedPost->slug]) }}" 
                                       class="hover:text-purple-600 transition">
                                        {{ $relatedPost->title }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-600">{{ $relatedPost->published_at->format('d/m/Y') }}</p>
                            </div>
                        </article>
                    @endforeach
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
