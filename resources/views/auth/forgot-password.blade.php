<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - AzendaMe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen">
    
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
                
                <!-- Logo -->
                <div class="mb-8 text-center">
                    <a href="{{ url('/') }}" class="inline-block">
                        <div class="flex items-center gap-3 justify-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center">
                                <img src="{{ asset('favicon-16x16.png') }}" alt="aZendeMe" class="w-8 h-8">
                            </div>
                            <span class="text-3xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">aZendeMe</span>
                        </div>
                    </a>
                </div>

                <div class="mb-8 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-black text-gray-900 mb-2">Esqueceu sua senha?</h2>
                    <p class="text-gray-600">
                        Sem problemas! Digite seu email e enviaremos um link para você redefinir sua senha.
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-green-700 text-sm font-medium">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 transition @error('email') border-red-500 @enderror"
                            placeholder="seu@email.com"
                        />
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full px-6 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold text-lg rounded-xl hover:shadow-2xl transform hover:scale-[1.02] transition"
                    >
                        Enviar Link de Recuperação
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
                    <a href="{{ route('login') }}" class="block text-purple-600 hover:text-purple-700 font-bold transition">
                        ← Voltar para o Login
                    </a>
                    <a href="{{ url('/') }}" class="block text-gray-700 hover:text-purple-600 font-semibold transition">
                        Ir para o site
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
