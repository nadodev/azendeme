@extends('panel.layout')

@section('page-title', 'Visualizar Post')
@section('page-subtitle', 'Detalhes do post')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header do Post -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-4">
                    @switch($post->status)
                        @case('published')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Publicado
                            </span>
                            @break
                        @case('draft')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Rascunho
                            </span>
                            @break
                        @case('scheduled')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Agendado
                            </span>
                            @break
                    @endswitch

                    @if($post->featured)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Destaque
                        </span>
                    @endif
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                
                @if($post->excerpt)
                    <p class="text-lg text-gray-600 mb-6">{{ $post->excerpt }}</p>
                @endif

                <div class="flex items-center space-x-6 text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Criado em {{ $post->created_at->format('d/m/Y H:i') }}
                    </div>
                    
                    @if($post->published_at)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Publicado em {{ $post->published_at->format('d/m/Y H:i') }}
                        </div>
                    @endif

                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ number_format($post->views_count) }} visualizações
                    </div>
                </div>
            </div>

            <div class="flex space-x-2">
                <a href="{{ route('panel.blog.edit', $post->id) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Editar
                </a>
                <a href="{{ route('panel.blog.index') }}" 
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <!-- Imagem de Destaque -->
    @if($post->featured_image)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <img src="{{ $post->featured_image }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-64 object-cover">
        </div>
    @endif

    <!-- Conteúdo -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="prose max-w-none">
            <div class="whitespace-pre-wrap text-gray-800 leading-relaxed">{{ $post->content }}</div>
        </div>
    </div>

    <!-- Metadados -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Categoria e Tags -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Categoria e Tags</h3>
            
            @if($post->category)
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Categoria:</h4>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                          style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }};">
                        {{ $post->category->name }}
                    </span>
                </div>
            @endif

            @if($post->tags->count() > 0)
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Tags:</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" 
                                  style="background-color: {{ $tag->color }}20; color: {{ $tag->color }};">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Estatísticas -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Estatísticas</h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Visualizações:</span>
                    <span class="font-semibold text-gray-900">{{ number_format($post->views_count) }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Likes:</span>
                    <span class="font-semibold text-gray-900">{{ number_format($post->likes_count) }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Comentários:</span>
                    <span class="font-semibold text-gray-900">{{ $post->comments->count() }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Comentários Aprovados:</span>
                    <span class="font-semibold text-green-600">{{ $post->approvedComments->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Comentários -->
    @if($post->allow_comments && $post->comments->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Comentários ({{ $post->comments->count() }})</h3>
            
            <div class="space-y-4">
                @foreach($post->comments->take(5) as $comment)
                    <div class="border-l-4 border-gray-200 pl-4 py-2">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-gray-900">{{ $comment->author_name }}</span>
                                <span class="text-sm text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                {{ $comment->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($comment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($comment->status) }}
                            </span>
                        </div>
                        <p class="text-gray-700">{{ $comment->content }}</p>
                    </div>
                @endforeach
                
                @if($post->comments->count() > 5)
                    <div class="text-center">
                        <a href="{{ route('panel.blog.comments.index') }}?post={{ $post->id }}" 
                           class="text-blue-600 hover:text-blue-700 font-medium">
                            Ver todos os {{ $post->comments->count() }} comentários
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Ações Rápidas -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Ações Rápidas</h3>
        
        <div class="flex flex-wrap gap-3">
            <form action="{{ route('panel.blog.toggle-status', $post->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 {{ $post->status === 'published' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition">
                    {{ $post->status === 'published' ? 'Despublicar' : 'Publicar' }}
                </button>
            </form>

            <form action="{{ route('panel.blog.toggle-featured', $post->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 {{ $post->featured ? 'bg-gray-600 hover:bg-gray-700' : 'bg-purple-600 hover:bg-purple-700' }} text-white rounded-lg transition">
                    {{ $post->featured ? 'Remover Destaque' : 'Destacar' }}
                </button>
            </form>

            <a href="{{ route('panel.blog.comments.index') }}?post={{ $post->id }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Gerenciar Comentários
            </a>

            <form action="{{ route('panel.blog.destroy', $post->id) }}" method="POST" class="inline" 
                  onsubmit="return confirm('Tem certeza que deseja excluir este post? Esta ação não pode ser desfeita.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Excluir Post
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
