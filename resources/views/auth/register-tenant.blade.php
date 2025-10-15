<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Criar conta - aZendeMe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    <style>
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen">
    <!-- Background Effects -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(139,92,246,0.1),transparent_50%),radial-gradient(circle_at_70%_60%,rgba(236,72,153,0.1),transparent_50%)]" aria-hidden="true"></div>
    
    <div class="relative min-h-screen flex items-center justify-center p-4 lg:p-6">
        <!-- Header -->
        <div class="absolute top-4 left-4 lg:top-6 lg:left-6">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('logo.png') }}" alt="Logo aZendeMe" class="w-6 h-6 lg:w-8 lg:h-8">
                <span class="text-lg lg:text-2xl font-black">
                    <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">aZendeMe</span>
                </span>
            </a>
        </div>
        
        <div class="w-full max-w-2xl">
            <!-- Hero Section -->
            <div class="text-center mb-6 lg:mb-8">
                <div class="inline-flex items-center gap-2 px-3 lg:px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-xs lg:text-sm font-semibold mb-4 lg:mb-6">
                    ✨ Comece grátis hoje
                </div>
                <h1 class="text-3xl lg:text-4xl xl:text-5xl font-black mb-3 lg:mb-4">
                    Crie sua conta no
                    <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent animate-gradient">
                        aZendeMe
                    </span>
                </h1>
                <p class="text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto">
                    Transforme seu negócio com o sistema completo de agendamentos. Comece gratuitamente e evolua conforme cresce.
                </p>
            </div>
            
            <!-- Form Card -->
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl lg:rounded-3xl p-6 lg:p-8 shadow-2xl border border-white/20">
                <div class="text-center mb-6 lg:mb-8">
                    <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">Criar minha conta</h2>
                    <p class="text-sm lg:text-base text-gray-600">Preencha os dados abaixo para começar</p>
                </div>
                <form method="POST" action="{{ route('tenant.register.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Personal Info -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">1</span>
                            Informações Pessoais
                        </h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Seu nome completo</label>
                                <input name="name" value="{{ old('name') }}" required 
                                       class="w-full px-3 lg:px-4 py-2 lg:py-3 border border-gray-300 rounded-lg lg:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition text-sm lg:text-base" 
                                       placeholder="João Silva" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                                <input type="email" name="email" value="{{ old('email') }}" required 
                                       class="w-full px-3 lg:px-4 py-2 lg:py-3 border border-gray-300 rounded-lg lg:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition text-sm lg:text-base" 
                                       placeholder="joao@exemplo.com" />
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Senha</label>
                                <input type="password" name="password" required 
                                       class="w-full px-3 lg:px-4 py-2 lg:py-3 border border-gray-300 rounded-lg lg:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition text-sm lg:text-base" 
                                       placeholder="Mínimo 8 caracteres" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar senha</label>
                                <input type="password" name="password_confirmation" required 
                                       class="w-full px-3 lg:px-4 py-2 lg:py-3 border border-gray-300 rounded-lg lg:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition text-sm lg:text-base" 
                                       placeholder="Digite a senha novamente" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Business Info -->
                    <div class="space-y-4 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <span class="w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold">2</span>
                            Informações do Negócio
                        </h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome do seu negócio</label>
                            <input name="business_name" value="{{ old('business_name') }}" required 
                                   class="w-full px-3 lg:px-4 py-2 lg:py-3 border border-gray-300 rounded-lg lg:rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition text-sm lg:text-base" 
                                   placeholder="Salão da Maria, Clínica Dr. João, etc." />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">URL personalizada</label>
                            <div class="flex">
                                <span class="px-3 lg:px-4 py-2 lg:py-3 border border-r-0 border-gray-300 rounded-l-lg lg:rounded-l-xl bg-gray-50 text-gray-600 text-xs lg:text-sm">
                                    {{ url('/') }}/
                                </span>
                                <input name="slug" value="{{ old('slug') }}" required pattern="[A-Za-z0-9_-]+" 
                                       class="flex-1 px-3 lg:px-4 py-2 lg:py-3 border border-gray-300 rounded-r-lg lg:rounded-r-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition text-sm lg:text-base" 
                                       placeholder="meu-negocio" />
                            </div>
                            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Use apenas letras, números, hífen e underscore. Exemplo: salao-maria, clinica-joao
                            </p>
                        </div>
                    </div>
                    
                    <!-- Errors -->
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-red-800 mb-2">Corrija os seguintes erros:</h4>
                                    <ul class="text-sm text-red-700 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full px-6 lg:px-8 py-3 lg:py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg lg:rounded-xl font-bold text-base lg:text-lg hover:shadow-lg transform hover:scale-105 transition">
                            🚀 Criar minha conta grátis
                        </button>
                    </div>
                </form>
                
                <!-- Footer -->
                <div class="text-center mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Já tem uma conta? 
                        <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-medium">Fazer login</a>
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        <a href="{{ url('/') }}" class="hover:underline">← Voltar ao site</a>
                    </p>
                </div>
            </div>
            
            <!-- Benefits Section -->
            <div class="mt-8 lg:mt-12 grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-green-100 rounded-xl lg:rounded-2xl flex items-center justify-center mx-auto mb-3 lg:mb-4">
                        <span class="text-lg lg:text-2xl">🚀</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-sm lg:text-base">Comece Grátis</h3>
                    <p class="text-xs lg:text-sm text-gray-600">Plano gratuito com funcionalidades essenciais para começar</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-blue-100 rounded-xl lg:rounded-2xl flex items-center justify-center mx-auto mb-3 lg:mb-4">
                        <span class="text-lg lg:text-2xl">⚡</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-sm lg:text-base">Setup em 5 minutos</h3>
                    <p class="text-xs lg:text-sm text-gray-600">Configure seu sistema e comece a receber agendamentos rapidamente</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 bg-purple-100 rounded-xl lg:rounded-2xl flex items-center justify-center mx-auto mb-3 lg:mb-4">
                        <span class="text-lg lg:text-2xl">📱</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-sm lg:text-base">Sua Marca</h3>
                    <p class="text-xs lg:text-sm text-gray-600">Página personalizada com suas cores, logo e informações</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
