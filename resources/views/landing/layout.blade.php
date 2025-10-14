<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>aZendame</title>
    @include('partials.favicon')
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <!-- Header simplificado -->
    <header class="bg-white border-b border-gray-200">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow">
                        <img src="{{ asset('favicon-16x16.png') }}" alt="aZendeMe" class="w-6 h-6">
                    </div>
                    <span class="text-xl font-black">
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">aZendeMe</span>
                    </span>
                </a>
                <div class="hidden md:flex items-center gap-6 text-sm">
                    <a href="/" class="text-gray-600 hover:text-purple-600">Início</a>
                    <a href="{{ url('/#precos') }}" class="text-gray-600 hover:text-purple-600">Preços</a>
                    <a href="{{ route('help.center') }}" class="text-gray-600 hover:text-purple-600">Central de Ajuda</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    @include('landing.sections.footer')
</body>
</html>


