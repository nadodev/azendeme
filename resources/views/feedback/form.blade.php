<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avalie seu Atendimento - {{ $feedbackRequest->professional->name }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gradient-to-br from-purple-50 to-pink-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-2xl p-8 md:p-12">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-pink-500 rounded-full mx-auto mb-4 flex items-center justify-center text-4xl">
                ⭐
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Como foi sua experiência?</h1>
            <p class="text-gray-600">Sua opinião é muito importante para nós!</p>
        </div>

        <!-- Info do Agendamento -->
        <div class="bg-purple-50 rounded-2xl p-6 mb-8">
            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Profissional:</span>
                    <span class="font-semibold text-gray-900 ml-2">{{ $feedbackRequest->professional->name }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Serviço:</span>
                    <span class="font-semibold text-gray-900 ml-2">{{ $feedbackRequest->service->name }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Data:</span>
                    <span class="font-semibold text-gray-900 ml-2">{{ $feedbackRequest->appointment->start_time->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Cliente:</span>
                    <span class="font-semibold text-gray-900 ml-2">{{ $feedbackRequest->customer->name }}</span>
                </div>
            </div>
        </div>

        <!-- Formulário -->
        <form method="POST" action="{{ route('feedback.store', $feedbackRequest->token) }}" class="space-y-8">
            @csrf

            <!-- Avaliação por Estrelas -->
            <div>
                <label class="block text-lg font-bold text-gray-900 mb-4 text-center">Qual sua nota para o atendimento?</label>
                <div class="flex justify-center gap-2 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <input type="radio" name="rating" value="{{ $i }}" id="star-{{ $i }}" class="hidden peer/star-{{ $i }}" required>
                        <label for="star-{{ $i }}" class="text-6xl cursor-pointer transition-all hover:scale-110 peer-checked/star-{{ $i }}:scale-125 star-label text-gray-300 hover:text-yellow-400 peer-checked/star-{{ $i }}:text-yellow-400">
                            ★
                        </label>
                    @endfor
                </div>
                <p class="text-center text-sm text-gray-500">Clique nas estrelas para avaliar</p>
            </div>

            <!-- Comentário -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Conte-nos mais sobre sua experiência</label>
                <textarea name="comment" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition" placeholder="Como foi o atendimento? O que achou do resultado?"></textarea>
            </div>

            <!-- O que mais gostou -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">O que você mais gostou? ✨</label>
                <input type="text" name="what_liked" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition" placeholder="Ex: Atendimento, qualidade, ambiente...">
            </div>

            <!-- O que pode melhorar -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">O que podemos melhorar? 💡</label>
                <input type="text" name="what_improve" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition" placeholder="Sugestões são sempre bem-vindas!">
            </div>

            <!-- Recomendaria? -->
            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                <input type="checkbox" name="would_recommend" value="1" checked id="recommend" class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500">
                <label for="recommend" class="text-sm font-semibold text-gray-900 cursor-pointer">Eu recomendaria este profissional para amigos e familiares</label>
            </div>

            <!-- Botão de Envio -->
            <button type="submit" class="w-full py-4 bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-2xl transition-all hover:scale-105">
                Enviar Avaliação
            </button>
        </form>
    </div>

    <script>
        // Sistema de estrelas interativo
        const stars = document.querySelectorAll('.star-label');
        const starInputs = document.querySelectorAll('input[name="rating"]');

        starInputs.forEach((input, index) => {
            input.addEventListener('change', () => {
                stars.forEach((star, i) => {
                    if (i <= index) {
                        star.classList.add('text-yellow-400');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });
            });
        });

        // Hover effect
        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => {
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    }
                });
            });
        });

        document.querySelector('form').addEventListener('mouseleave', () => {
            const checkedInput = document.querySelector('input[name="rating"]:checked');
            if (checkedInput) {
                const checkedIndex = Array.from(starInputs).indexOf(checkedInput);
                stars.forEach((star, i) => {
                    if (i <= checkedIndex) {
                        star.classList.add('text-yellow-400');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });
            } else {
                stars.forEach(star => {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                });
            }
        });
    </script>
</body>
</html>

