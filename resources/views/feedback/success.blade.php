<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação Enviada - Obrigado!</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-2xl p-8 md:p-12 text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-full mx-auto mb-6 flex items-center justify-center text-5xl animate-bounce">
            ✓
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Muito Obrigado!</h1>
        <p class="text-gray-600 text-lg mb-8">Sua avaliação foi enviada com sucesso e é muito importante para nós!</p>
        
        <div class="bg-purple-50 rounded-2xl p-6 mb-8">
            <div class="text-6xl mb-2">
                {!! $feedback->getStarsHtml() !!}
            </div>
            <p class="text-sm text-gray-600">Você avaliou com {{ $feedback->rating }} estrela{{ $feedback->rating > 1 ? 's' : '' }}</p>
        </div>

        @if($feedback->comment)
        <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left">
            <p class="text-sm text-gray-600 mb-1">Seu comentário:</p>
            <p class="text-gray-900 italic">"{{ $feedback->comment }}"</p>
        </div>
        @endif

        <a href="/" class="inline-block px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold rounded-xl shadow-lg hover:shadow-2xl transition">
            Voltar ao Início
        </a>
    </div>
</body>
</html>

