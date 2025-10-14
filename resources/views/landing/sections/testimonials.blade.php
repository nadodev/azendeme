<!-- Depoimentos -->
<section id="depoimentos" class="py-24 bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-4">
                ⭐ Avaliações
            </div>
            <h2 class="text-4xl md:text-5xl font-black mb-4">
                O que nossos clientes
                <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">dizem sobre nós</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Profissionais de todo Brasil já transformaram seus negócios com o AzendaMe
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @php
            $testimonials = [
                [
                    'name' => 'Ana Paula Silva',
                    'business' => 'Studio de Beleza Ana',
                    'city' => 'São Paulo, SP',
                    'photo' => 'https://i.pravatar.cc/100?img=5',
                    'rating' => 5,
                    'text' => 'Depois que comecei a usar o AzendaMe, minha agenda ficou completamente organizada. O sistema de fidelidade aumentou muito a retenção de clientes!',
                    'color' => 'purple'
                ],
                [
                    'name' => 'Carlos Mendes',
                    'business' => 'Barbearia do Carlos',
                    'city' => 'Rio de Janeiro, RJ',
                    'photo' => 'https://i.pravatar.cc/100?img=12',
                    'rating' => 5,
                    'text' => 'Sistema completo! O link rápido no Instagram aumentou meus agendamentos em 200%. Os clientes amam a facilidade.',
                    'color' => 'blue'
                ],
                [
                    'name' => 'Dra. Mariana Costa',
                    'business' => 'Clínica Vitta',
                    'city' => 'Belo Horizonte, MG',
                    'photo' => 'https://i.pravatar.cc/100?img=30',
                    'rating' => 5,
                    'text' => 'Os lembretes automáticos reduziram as faltas em 80%! O relatório financeiro facilitou muito a gestão da clínica.',
                    'color' => 'pink'
                ],
                [
                    'name' => 'Lucas Tattoo',
                    'business' => 'Black Ink Studio',
                    'city' => 'Curitiba, PR',
                    'photo' => 'https://i.pravatar.cc/100?img=15',
                    'rating' => 5,
                    'text' => 'A galeria de fotos no template de tatuagem ficou incrível! Meus trabalhos aparecem de forma profissional e moderna.',
                    'color' => 'purple'
                ],
                [
                    'name' => 'Juliana Ferreira',
                    'business' => 'Espaço Juliana Spa',
                    'city' => 'Brasília, DF',
                    'photo' => 'https://i.pravatar.cc/100?img=25',
                    'rating' => 5,
                    'text' => 'O sistema de promoções me ajudou a reativar clientes antigos. As campanhas segmentadas são muito eficientes!',
                    'color' => 'pink'
                ],
                [
                    'name' => 'Roberto Alves',
                    'business' => 'Clínica Dr. Roberto',
                    'city' => 'Porto Alegre, RS',
                    'photo' => 'https://i.pravatar.cc/100?img=33',
                    'rating' => 5,
                    'text' => 'Melhor investimento que fiz! O suporte é excelente e o sistema tem tudo que preciso. Recomendo muito!',
                    'color' => 'blue'
                ]
            ];
            @endphp

            @foreach($testimonials as $testimonial)
            <div class="bg-white rounded-2xl p-8 shadow-lg border-2 border-gray-100 hover:border-{{ $testimonial['color'] }}-300 hover:shadow-2xl transition-all">
                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ $testimonial['photo'] }}" alt="{{ $testimonial['name'] }}" class="w-16 h-16 rounded-full border-4 border-{{ $testimonial['color'] }}-100">
                    <div>
                        <h4 class="font-bold text-lg">{{ $testimonial['name'] }}</h4>
                        <p class="text-sm text-gray-600">{{ $testimonial['business'] }}</p>
                        <p class="text-xs text-gray-500">{{ $testimonial['city'] }}</p>
                    </div>
                </div>

                <div class="flex gap-1 mb-4">
                    @for($i = 0; $i < $testimonial['rating']; $i++)
                        <span class="text-yellow-400 text-xl">★</span>
                    @endfor
                </div>

                <p class="text-gray-700 leading-relaxed italic">"{{ $testimonial['text'] }}"</p>
            </div>
            @endforeach
        </div>

        <!-- Stats -->
        <div class="grid md:grid-cols-4 gap-8 bg-white rounded-3xl p-12 shadow-lg border-2 border-gray-100">
            <div class="text-center">
                <div class="text-5xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                    500+
                </div>
                <p class="text-gray-600 font-semibold">Profissionais Ativos</p>
            </div>
            <div class="text-center">
                <div class="text-5xl font-black bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-2">
                    50k+
                </div>
                <p class="text-gray-600 font-semibold">Agendamentos/Mês</p>
            </div>
            <div class="text-center">
                <div class="text-5xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">
                    98%
                </div>
                <p class="text-gray-600 font-semibold">Satisfação</p>
            </div>
            <div class="text-center">
                <div class="text-5xl font-black bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">
                    4.9
                </div>
                <p class="text-gray-600 font-semibold">Avaliação Média</p>
            </div>
        </div>
    </div>
</section>

