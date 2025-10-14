@extends('panel.layout')

@section('title', 'Redes Sociais')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📱 Integração com Redes Sociais</h1>
            <p class="text-gray-600 mt-2">Compartilhe seu link de agendamento e conecte suas redes sociais</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- Link Direto de Agendamento -->
    <div class="bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold mb-2">🔗 Link Direto de Agendamento</h2>
                <p class="text-purple-100">Compartilhe este link em suas redes sociais para agendamentos diretos</p>
            </div>
        </div>

        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 mb-4">
            <div class="flex items-center gap-3">
                <input type="text" value="{{ $bookingUrl }}" id="booking-url" readonly 
                    class="flex-1 px-4 py-3 bg-white text-gray-900 rounded-lg font-mono text-sm">
                <button onclick="copyBookingUrl()" class="px-6 py-3 bg-white text-purple-600 rounded-lg hover:bg-purple-50 transition font-semibold whitespace-nowrap">
                    📋 Copiar
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- WhatsApp -->
            <a href="https://wa.me/?text={{ urlencode('Agende seu horário: ' . $bookingUrl) }}" target="_blank" 
                class="flex items-center justify-center gap-2 px-4 py-3 bg-green-500 hover:bg-green-600 rounded-lg transition font-semibold">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                WhatsApp
            </a>

            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($bookingUrl) }}" target="_blank" 
                class="flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg transition font-semibold">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook
            </a>

            <!-- Twitter -->
            <a href="https://twitter.com/intent/tweet?url={{ urlencode($bookingUrl) }}&text={{ urlencode('Agende seu horário comigo!') }}" target="_blank" 
                class="flex items-center justify-center gap-2 px-4 py-3 bg-sky-500 hover:bg-sky-600 rounded-lg transition font-semibold">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
                Twitter
            </a>

            <!-- LinkedIn -->
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($bookingUrl) }}" target="_blank" 
                class="flex items-center justify-center gap-2 px-4 py-3 bg-blue-700 hover:bg-blue-800 rounded-lg transition font-semibold">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
                LinkedIn
            </a>
        </div>
    </div>

    <!-- QR Code -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                QR Code de Agendamento
            </h2>
        </div>
        <div class="p-6 text-center">
            <p class="text-gray-600 mb-4">Clientes podem escanear este QR Code para agendar direto</p>
            <div class="inline-block p-4 bg-white border-4 border-gray-200 rounded-xl">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($qrCodeData) }}" alt="QR Code" class="w-64 h-64">
            </div>
            <div class="mt-4">
                <a href="https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data={{ urlencode($qrCodeData) }}" download="qrcode-agendamento.png" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    📥 Baixar QR Code (Alta Qualidade)
                </a>
            </div>
        </div>
    </div>

    <!-- Bio para Redes Sociais -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white">📝 Bio para Redes Sociais</h2>
        </div>
        <form action="{{ route('panel.social.update-bio') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Texto da Bio (máx. 500 caracteres)
                </label>
                <textarea name="bio" rows="4" maxlength="500"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                    placeholder="Ex: Profissional especializado em... Agende seu horário pelo link abaixo! 👇">{{ old('bio', $professional->bio) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Use esta bio no Instagram, TikTok, Facebook, etc.</p>
            </div>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                Salvar Bio
            </button>
        </form>
    </div>

    <!-- Links de Redes Sociais -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-pink-600 to-orange-600 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white">🌐 Seus Links de Redes Sociais</h2>
            <button onclick="document.getElementById('add-social-modal').classList.remove('hidden')" class="px-4 py-2 bg-white text-pink-600 rounded-lg hover:bg-pink-50 transition font-semibold">
                + Adicionar Rede
            </button>
        </div>

        <div class="p-6">
            @if($socialLinks->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <p class="text-gray-500 text-lg mb-4">Nenhuma rede social conectada ainda</p>
                    <button onclick="document.getElementById('add-social-modal').classList.remove('hidden')" class="px-6 py-3 bg-gradient-to-r from-pink-600 to-orange-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                        Adicionar Primeira Rede Social
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($socialLinks as $link)
                        @php
                            $icons = [
                                'instagram' => ['color' => 'from-purple-600 to-pink-600', 'emoji' => '📸'],
                                'facebook' => ['color' => 'from-blue-600 to-blue-700', 'emoji' => '👥'],
                                'tiktok' => ['color' => 'from-gray-900 to-gray-700', 'emoji' => '🎵'],
                                'whatsapp' => ['color' => 'from-green-500 to-green-600', 'emoji' => '💬'],
                                'linkedin' => ['color' => 'from-blue-700 to-blue-800', 'emoji' => '💼'],
                                'youtube' => ['color' => 'from-red-600 to-red-700', 'emoji' => '▶️'],
                                'twitter' => ['color' => 'from-sky-500 to-sky-600', 'emoji' => '🐦'],
                                'website' => ['color' => 'from-gray-600 to-gray-700', 'emoji' => '🌐'],
                            ];
                            $config = $icons[$link->platform] ?? ['color' => 'from-gray-600 to-gray-700', 'emoji' => '🔗'];
                        @endphp
                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br {{ $config['color'] }} rounded-lg flex items-center justify-center text-2xl">
                                        {{ $config['emoji'] }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 capitalize">{{ $link->platform }}</h3>
                                        @if($link->username)
                                            <p class="text-sm text-gray-600">@{{ $link->username }}</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $link->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                                    {{ $link->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <a href="{{ $link->url }}" target="_blank" class="text-sm text-blue-600 hover:underline break-all">
                                    {{ Str::limit($link->url, 50) }}
                                </a>
                            </div>

                            <div class="flex gap-2">
                                <button onclick="editSocialLink({{ $link->id }}, '{{ $link->platform }}', '{{ $link->url }}', '{{ $link->username }}', {{ $link->is_active ? 'true' : 'false' }})" 
                                    class="flex-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                                    Editar
                                </button>
                                <form action="{{ route('panel.social.destroy', $link->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Deseja excluir este link?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-semibold">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Adicionar Rede Social -->
<div id="add-social-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900">Adicionar Rede Social</h3>
            <button onclick="document.getElementById('add-social-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('panel.social.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Plataforma *</label>
                <select name="platform" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <option value="instagram">Instagram</option>
                    <option value="facebook">Facebook</option>
                    <option value="tiktok">TikTok</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="youtube">YouTube</option>
                    <option value="twitter">Twitter</option>
                    <option value="website">Website</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">URL Completa *</label>
                <input type="url" name="url" required placeholder="https://instagram.com/seu_usuario"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Usuário/Nome</label>
                <input type="text" name="username" placeholder="@seu_usuario"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" checked
                        class="w-5 h-5 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                    <span class="text-gray-700 font-medium">Link Ativo</span>
                </label>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('add-social-modal').classList.add('hidden')" 
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-pink-600 to-orange-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                    Adicionar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Rede Social -->
<div id="edit-social-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900">Editar Rede Social</h3>
            <button onclick="document.getElementById('edit-social-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="edit-social-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Plataforma *</label>
                <select name="platform" id="edit_platform" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <option value="instagram">Instagram</option>
                    <option value="facebook">Facebook</option>
                    <option value="tiktok">TikTok</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="youtube">YouTube</option>
                    <option value="twitter">Twitter</option>
                    <option value="website">Website</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">URL Completa *</label>
                <input type="url" name="url" id="edit_url" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Usuário/Nome</label>
                <input type="text" name="username" id="edit_username"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1"
                        class="w-5 h-5 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                    <span class="text-gray-700 font-medium">Link Ativo</span>
                </label>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('edit-social-modal').classList.add('hidden')" 
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Cancelar
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-pink-600 to-orange-600 text-white rounded-lg hover:shadow-lg transition font-semibold">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function copyBookingUrl() {
        const input = document.getElementById('booking-url');
        input.select();
        document.execCommand('copy');
        alert('Link copiado para a área de transferência!');
    }

    function editSocialLink(id, platform, url, username, isActive) {
        const form = document.getElementById('edit-social-form');
        form.action = `/panel/social/${id}`;
        
        document.getElementById('edit_platform').value = platform;
        document.getElementById('edit_url').value = url;
        document.getElementById('edit_username').value = username || '';
        document.getElementById('edit_is_active').checked = isActive;
        
        document.getElementById('edit-social-modal').classList.remove('hidden');
    }
</script>
@endsection

