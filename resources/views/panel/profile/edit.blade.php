@extends('panel.layout')

@section('title', 'Editar Perfil')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    @if(session('success'))
        <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Editar Perfil</h1>
                <p class="text-gray-600 mt-1">Atualize suas informações pessoais</p>
            </div>
            <a href="{{ route('panel.profile') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                ← Voltar ao perfil
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Information Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Informações Pessoais</h2>
                
                <form method="POST" action="{{ route('panel.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Avatar Upload -->
                        <div class="flex items-center space-x-6">
                            <div class="relative">
                                <img id="avatar-preview" src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-gray-200">
                                <label for="avatar" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 cursor-pointer hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </label>
                                <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Foto do Perfil</h3>
                                <p class="text-sm text-gray-600">Clique na câmera para alterar sua foto</p>
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG ou GIF. Máximo 2MB.</p>
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
                            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   required>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                Salvar Alterações
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Change -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Alterar Senha</h2>
                
                <form method="POST" action="{{ route('panel.profile.password') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Senha Atual</label>
                            <input type="password" id="current_password" name="current_password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   required>
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nova Senha</label>
                            <input type="password" id="password" name="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   required>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nova Senha</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 transition-colors font-medium">
                            Alterar Senha
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Information -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Informações da Conta</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">ID do Usuário</span>
                        <span class="font-mono text-sm text-gray-900">{{ auth()->user()->id }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Membro desde</span>
                        <span class="text-gray-900">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Última atualização</span>
                        <span class="text-gray-900">{{ auth()->user()->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Plano atual</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            {{ auth()->user()->plan === 'free' ? 'bg-gray-100 text-gray-800' : 
                               (auth()->user()->plan === 'premium' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                            {{ strtoupper(auth()->user()->plan) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
