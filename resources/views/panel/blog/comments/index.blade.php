@extends('panel.layout')

@section('page-title', 'Comentários do Blog')
@section('page-subtitle', 'Gerencie os comentários dos seus posts')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $comments->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Pendentes</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $comments->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Aprovados</p>
                    <p class="text-3xl font-bold text-green-600">{{ $comments->where('status', 'approved')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Rejeitados</p>
                    <p class="text-3xl font-bold text-red-600">{{ $comments->where('status', 'rejected')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div>
                    <label for="status_filter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status_filter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendentes</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprovados</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeitados</option>
                    </select>
                </div>

                <div>
                    <label for="post_filter" class="block text-sm font-medium text-gray-700 mb-1">Post</label>
                    <select id="post_filter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos os posts</option>
                        @foreach($posts as $post)
                            <option value="{{ $post->id }}" {{ request('post') == $post->id ? 'selected' : '' }}>
                                {{ Str::limit($post->title, 50) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button onclick="applyFilters()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Filtrar
                </button>
                <button onclick="clearFilters()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Limpar
                </button>
            </div>
        </div>
    </div>

    <!-- Ações em Massa -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form id="bulkForm" action="{{ route('panel.blog.comments.bulk-action') }}" method="POST">
            @csrf
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <select name="action" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Ação em massa</option>
                        <option value="approve">Aprovar selecionados</option>
                        <option value="reject">Rejeitar selecionados</option>
                        <option value="delete">Excluir selecionados</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        Executar
                    </button>
                </div>
                <div class="text-sm text-gray-500">
                    <span id="selectedCount">0</span> comentários selecionados
                </div>
            </div>
        </form>
    </div>

    <!-- Lista de Comentários -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Comentários</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAll" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comentário</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Post</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($comments as $comment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <input type="checkbox" name="comment_ids[]" value="{{ $comment->id }}" class="comment-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="font-medium text-gray-900">{{ $comment->author_name }}</span>
                                        @if($comment->author_email)
                                            <span class="text-sm text-gray-500">({{ $comment->author_email }})</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600">{{ Str::limit($comment->content, 100) }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('panel.blog.show', $comment->post->id) }}" class="text-blue-600 hover:text-blue-700 text-sm">
                                    {{ Str::limit($comment->post->title, 30) }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $comment->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($comment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($comment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $comment->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('panel.blog.comments.show', $comment->id) }}" class="text-blue-600 hover:text-blue-700">
                                    Ver
                                </a>
                                @if($comment->status !== 'approved')
                                    <form action="{{ route('panel.blog.comments.approve', $comment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-700">
                                            Aprovar
                                        </button>
                                    </form>
                                @endif
                                @if($comment->status !== 'rejected')
                                    <form action="{{ route('panel.blog.comments.reject', $comment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-700">
                                            Rejeitar
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('panel.blog.comments.destroy', $comment->id) }}" method="POST" class="inline" onsubmit="return confirm('Excluir este comentário?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <p class="text-gray-500 mb-4">Nenhum comentário encontrado</p>
                                <p class="text-sm text-gray-400">Os comentários dos seus posts aparecerão aqui</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($comments->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
</div>

<script>
// Seleção de todos os comentários
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.comment-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateSelectedCount();
});

// Atualizar contador de selecionados
document.querySelectorAll('.comment-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedCount);
});

function updateSelectedCount() {
    const selected = document.querySelectorAll('.comment-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = selected;
}

// Filtros
function applyFilters() {
    const status = document.getElementById('status_filter').value;
    const post = document.getElementById('post_filter').value;
    const url = new URL(window.location);
    
    if (status) url.searchParams.set('status', status);
    else url.searchParams.delete('status');
    
    if (post) url.searchParams.set('post', post);
    else url.searchParams.delete('post');
    
    window.location.href = url.toString();
}

function clearFilters() {
    window.location.href = window.location.pathname;
}
</script>
@endsection
