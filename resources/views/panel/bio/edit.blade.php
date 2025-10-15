@extends('panel.layout')

@section('title', 'Minha Bio')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Link público da sua Bio</h2>
                <p class="text-sm text-gray-600 mt-1">Use este link no Instagram, WhatsApp e onde desejar.</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <input id="bioPublicUrl" type="text" readonly value="{{ route('public.bio', $page->slug) }}" class="hidden md:block w-96 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                <a href="{{ route('public.bio', $page->slug) }}" target="_blank" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Pré-visualizar</a>
                <button type="button" onclick="copyBioUrl()" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">Copiar</button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('panel.events.bio.update') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Básicas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                        <input type="text" name="title" value="{{ old('title', $page->title) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slug *</label>
                        <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        <p class="text-xs text-gray-500 mt-1">URL pública: {{ url('/bio/' . old('slug', $page->slug)) }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Avatar</label>
                        <input type="file" name="avatar" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        @if($page->avatar_path)
                            <img src="{{ asset($page->avatar_path) }}" class="mt-3 w-24 h-24 rounded-full object-cover border-4 border-purple-100" alt="Avatar">
                        @endif
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('description', $page->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Agendamento pela Bio</h3>
                <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Habilitar botão "Agendar" na página pública</p>
                        <p class="text-xs text-gray-600">Quando ativo, a página exibirá um botão que abre um painel com serviços e calendário disponíveis.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="enable_booking" value="1" class="sr-only peer" {{ old('enable_booking', $page->enable_booking) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 rounded-full transition peer-checked:bg-purple-600"></div>
                        <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Redes Sociais</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                Instagram
                            </span>
                        </label>
                        <input type="url" name="instagram_url" value="{{ old('instagram_url', $page->instagram_url) }}" placeholder="https://instagram.com/seu_perfil" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                WhatsApp
                            </span>
                        </label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $page->whatsapp_number) }}" placeholder="5599999999999" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                Facebook
                            </span>
                        </label>
                        <input type="url" name="facebook_url" value="{{ old('facebook_url', $page->facebook_url) }}" placeholder="https://facebook.com/seu_perfil" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                YouTube
                            </span>
                        </label>
                        <input type="url" name="youtube_url" value="{{ old('youtube_url', $page->youtube_url) }}" placeholder="https://youtube.com/@seu_canal" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                TikTok
                            </span>
                        </label>
                        <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $page->tiktok_url) }}" placeholder="https://tiktok.com/@seu_perfil" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                LinkedIn
                            </span>
                        </label>
                        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $page->linkedin_url) }}" placeholder="https://linkedin.com/in/seu_perfil" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Tema da Página</h3>
                <p class="text-sm text-gray-600 mb-4">Escolha um tema que combine com sua marca. As cores do fundo, botões e ícones serão aplicadas automaticamente.</p>
                <input type="hidden" name="theme" id="theme" value="{{ old('theme', $page->theme ?? 'lavender-air') }}">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @php
                        $themes = [
                            'minimal-white' => ['bg' => '#F6F7F9', 'name' => 'Minimalista'],
                            'clinic-soft'   => ['bg' => '#F3FAFF', 'name' => 'Clínica Soft'],
                            'mint-fresh'    => ['bg' => '#F1FFF6', 'name' => 'Menta Fresh'],
                            'beauty-blush'  => ['bg' => 'linear-gradient(180deg, #FFE3EC, #FFF7FA)', 'name' => 'Beauty Blush'],
                            'sand-cream'    => ['bg' => 'linear-gradient(180deg, #FFF5E6, #FFFFFF)', 'name' => 'Areia Cream'],
                            'lavender-air'  => ['bg' => 'linear-gradient(180deg, #E0E7FF, #F0F4FF)', 'name' => 'Lavanda Air'],
                            'sky-clean'     => ['bg' => 'linear-gradient(180deg, #E0F2FE, #F0F9FF)', 'name' => 'Sky Clean'],
                            'pearl-gray'    => ['bg' => 'linear-gradient(180deg, #F8FAFC, #FFFFFF)', 'name' => 'Pearl Gray'],
                        ];
                        $selected = old('theme', $page->theme ?? 'lavender-air');
                    @endphp
                    @foreach($themes as $key => $info)
                        <button type="button" onclick="selectTheme('{{ $key }}', this)" class="relative rounded-2xl h-24 border-4 {{ $selected === $key ? 'border-purple-600' : 'border-gray-200' }} focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all overflow-hidden" style="background: {{ $info['bg'] }}">
                            <span class="absolute bottom-2 left-0 right-0 text-center text-xs font-medium text-gray-700 bg-white/80 py-1 mx-2 rounded">{{ $info['name'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Links Personalizados</h3>
                <p class="text-sm text-gray-600 mb-4">Adicione links para seus serviços, produtos ou conteúdos. Os ícones são detectados automaticamente.</p>
                <div id="links" class="space-y-3">
                    @php $oldLinks = old('links', $links->toArray()); @endphp
                    @foreach($oldLinks as $i => $link)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 p-3 bg-gray-50 rounded-lg">
                            <input type="text" name="links[{{ $i }}][label]" value="{{ $link['label'] ?? '' }}" placeholder="Título do link" class="px-3 py-2 border border-gray-300 rounded-lg">
                            <input type="url" name="links[{{ $i }}][url]" value="{{ $link['url'] ?? '' }}" placeholder="https://..." class="px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="addLink()" class="mt-3 px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 font-medium">+ Adicionar link</button>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t">
                <a href="{{ route('public.bio', $page->slug) }}" target="_blank" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Pré-visualizar</a>
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium">Salvar alterações</button>
            </div>
        </form>
    </div>
</div>

<script>
function copyBioUrl(){
    const url = "{{ route('public.bio', $page->slug) }}";
    if (navigator.clipboard){ navigator.clipboard.writeText(url); alert('Link copiado!'); }
    else { window.prompt('Copie o link:', url); }
}
function selectTheme(key, el){
    document.getElementById('theme').value = key;
    document.querySelectorAll('[onclick^="selectTheme"]').forEach(btn=>{
        btn.classList.remove('border-purple-600');
        btn.classList.add('border-gray-200');
    });
    el.classList.remove('border-gray-200');
    el.classList.add('border-purple-600');
}
let linkIndex = {{ count(old('links', $links)) }};
function addLink(){
    const c = document.getElementById('links');
    const row = document.createElement('div');
    row.className = 'grid grid-cols-1 md:grid-cols-2 gap-3 p-3 bg-gray-50 rounded-lg';
    row.innerHTML = `
        <input type="text" name="links[${linkIndex}][label]" placeholder="Título do link" class="px-3 py-2 border border-gray-300 rounded-lg">
        <input type="url" name="links[${linkIndex}][url]" placeholder="https://..." class="px-3 py-2 border border-gray-300 rounded-lg">
    `;
    c.appendChild(row);
    linkIndex++;
}
</script>
@endsection
