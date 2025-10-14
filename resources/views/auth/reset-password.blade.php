<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - AzendaMe</title>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-black text-gray-900 mb-2">Redefinir Senha</h2>
                    <p class="text-gray-600">
                        Crie uma nova senha segura para sua conta
                    </p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                            Email
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $request->email) }}" 
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
                            Nova Senha
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 transition @error('password') border-red-500 @enderror"
                            placeholder="Mínimo 8 caracteres"
                        />
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">
                            A senha deve ter no mínimo 8 caracteres
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                            Confirmar Nova Senha
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-100 transition @error('password_confirmation') border-red-500 @enderror"
                            placeholder="Digite a senha novamente"
                        />
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full px-6 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold text-lg rounded-xl hover:shadow-2xl transform hover:scale-[1.02] transition"
                    >
                        Redefinir Senha
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
                </div>
            </div>
        </div>
    </div>

</body>
</html>
