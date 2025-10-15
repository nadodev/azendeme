<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AzendeMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen">
    
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-6xl w-full grid md:grid-cols-2 gap-8 items-center">
            
            <!-- Left Side - Branding -->
            <div class="hidden md:block">
                <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-3xl p-12 text-white shadow-2xl">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="relative">
                                <img src="{{ asset('logo.png') }}" alt="aZendeMe" class="w-16 h-16 drop-shadow-2xl">
                                <div class="absolute -inset-2 bg-white/20 rounded-full blur-xl"></div>
                            </div>
                            <div>
                                <span class="text-4xl font-black text-white drop-shadow-lg">aZendeMe</span>
                                <p class="text-white/80 text-sm font-medium">Sistema de Agendamentos</p>
                            </div>
                        </div>
                    <h1 class="text-4xl font-black mb-6 leading-tight">
                        Gerencie seu negócio com profissionalismo
                    </h1>
                    
                    <p class="text-xl text-purple-100 mb-8 leading-relaxed">
                        Sistema completo de agendamento, fidelidade, promoções e muito mais!
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <span class="text-lg">Agenda Online Personalizada</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <span class="text-lg">Programa de Fidelidade</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <span class="text-lg">Gestão de Equipe</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <span class="text-lg">Relatórios e Analytics</span>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-white/20">
                        <p class="text-sm text-purple-100">
                            Ainda não tem acesso? 
                            <a href="/registrar" class="font-bold text-white hover:underline">Cadastre-se grátis</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full">
                <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
                    
                    <!-- Mobile Logo -->
                    <div class="md:hidden mb-8 text-center">
                        <a href="{{ url('/') }}" class="inline-block">
                            <div class="flex items-center gap-4 justify-center">
                                <div class="relative">
                                    <img src="{{ asset('logo.png') }}" alt="aZendeMe" class="w-12 h-12 drop-shadow-xl">
                                    <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full blur-lg opacity-30"></div>
                                </div>
                                <div class="text-center">
                                    <span class="text-3xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent drop-shadow-sm">aZendeMe</span>
                                    <p class="text-gray-600 text-xs font-medium">Sistema de Agendamentos</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-3xl font-black text-gray-900 mb-2">Bem-vindo de volta!</h2>
                        <p class="text-gray-600">Faça login para acessar seu painel</p>
                    </div>

    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <p class="text-green-700 text-sm">{{ session('status') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                                Email
                            </label>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus 
                                autocomplete="username"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 transition @error('email') border-red-500 @enderror"
                                placeholder="seu@email.com"
                            />
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
        </div>

        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                                Senha
                            </label>
                            <input 
                                id="password" 
                            type="password"
                            name="password"
                                required 
                                autocomplete="current-password"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 transition @error('password') border-red-500 @enderror"
                                placeholder="••••••••"
                            />
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    name="remember"
                                    class="w-5 h-5 border-2 border-gray-300 rounded text-purple-600 focus:ring-4 focus:ring-purple-100"
                                >
                                <span class="ml-2 text-sm text-gray-700">Lembrar-me</span>
            </label>

            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-purple-600 hover:text-purple-700 transition">
                                    Esqueceu a senha?
                </a>
            @endif
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit"
                            class="w-full px-6 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold text-lg rounded-xl hover:shadow-2xl transform hover:scale-[1.02] transition"
                        >
                            Entrar
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="my-8 flex items-center gap-4">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="text-sm text-gray-500 font-medium">OU</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <!-- Links -->
                    <div class="text-center space-y-4">
                        <a href="{{ url('/') }}" class="block text-gray-700 hover:text-purple-600 font-semibold transition">
                            ← Voltar para o site
                        </a>
                        <p class="text-sm text-gray-600">
                            Não tem acesso ao sistema? 
                            <a href="{{ url('/registrar') }}" class="font-bold text-purple-600 hover:text-purple-700 transition">
                                Cadastre-se grátis
                            </a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
