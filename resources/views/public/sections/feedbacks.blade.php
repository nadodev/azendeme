<!-- Feedbacks/Avaliações -->
<section id="avaliacoes" class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold mb-4 text-white shadow-lg" style="background: var(--brand)">
                ⭐ Avaliações
            </span>
            <h3 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">O que nossos clientes dizem</h3>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Confira a experiência de quem já foi atendido</p>
        </div>

        @if($feedbacks && $feedbacks->count() > 0)
            <!-- Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="text-5xl font-bold mb-2" style="color: var(--brand)">
                        {{ number_format($feedbacks->avg('rating'), 1) }}
                    </div>
                    <div class="text-2xl text-yellow-400 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($feedbacks->avg('rating')))
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                    <p class="text-gray-600">Média de Avaliação</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="text-5xl font-bold mb-2" style="color: var(--brand)">{{ $feedbacks->count() }}</div>
                    <p class="text-gray-600">Avaliações</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="text-5xl font-bold mb-2" style="color: var(--brand)">
                        {{ round(($feedbacks->where('would_recommend', true)->count() / $feedbacks->count()) * 100) }}%
                    </div>
                    <p class="text-gray-600">Recomendam</p>
                </div>
            </div>

            <!-- Lista de Feedbacks -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($feedbacks as $feedback)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all">
                        <!-- Estrelas -->
                        <div class="text-3xl text-yellow-400 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $feedback->rating)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </div>

                        <!-- Comentário -->
                        @if($feedback->comment)
                            <p class="text-gray-700 mb-4 italic">"{{ Str::limit($feedback->comment, 150) }}"</p>
                        @endif

                        <!-- Cliente e Serviço -->
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <p class="font-semibold text-gray-900">{{ $feedback->customer->name }}</p>
                            <p class="text-sm text-gray-500">{{ $feedback->service->name }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $feedback->created_at->diffForHumans() }}</p>
                        </div>

                        <!-- Tags -->
                        <div class="mt-3 flex flex-wrap gap-2">
                            @if($feedback->what_liked)
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                                    ✨ {{ Str::limit($feedback->what_liked, 20) }}
                                </span>
                            @endif
                            @if($feedback->would_recommend)
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">
                                    👍 Recomenda
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">⭐</div>
                <p class="text-gray-500 text-lg">Seja o primeiro a avaliar!</p>
            </div>
        @endif
    </div>
</section>

