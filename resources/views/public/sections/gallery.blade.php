<!-- Galeria por Álbuns -->
<section id="galeria" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Galeria</h3>
            <p class="text-gray-600 text-lg">Veja alguns dos nossos trabalhos</p>
        </div>

        @php
            $grouped = ($gallery ?? collect())->groupBy('album_id');

        @endphp

        @if(($grouped->count() ?? 0) > 0)
            <!-- Lista de Álbuns -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="albums-grid">
                @foreach($grouped as $albumId => $photos)
                    @php
                        $cover = $photos->sortBy('order')->first();
                        $albumName = optional($cover->album)->name ?? 'Geral';
                        $count = $photos->count();
                        $target = 'album-'.($albumId ?? 'default');
                    @endphp
                    <div class="rounded-2xl overflow-hidden shadow group cursor-pointer" onclick="openAlbumModal('{{ $target }}', '{{ addslashes($albumName) }}')">
                        <div class="relative h-56 bg-gray-100">
                            @if($cover)
                                <img src="{{ $cover->image_path }}" alt="{{ $albumName }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-lg">{{ $albumName }}</h4>
                                    <span class="text-sm bg-white/20 px-2 py-0.5 rounded">{{ $count }} fotos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Álbuns (conteúdo) -->
            @foreach($grouped as $albumId => $photos)
                @php
                    $albumName = optional(optional($photos->first())->album)->name ?? 'Geral';
                    $target = 'album-'.($albumId ?? 'default');
                @endphp
                <div id="{{ $target }}" class="hidden">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($photos->sortBy('order') as $photo)
                            <div class="gallery-item relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all cursor-pointer" onclick="openPhotoModal('{{ $photo->image_path }}', '{{ addslashes($photo->title) }}', '{{ addslashes($photo->description) }}')">
                                <img src="{{ $photo->image_path }}" alt="{{ $photo->title }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                    <div class="text-white">
                                        <h5 class="font-bold">{{ $photo->title }}</h5>
                                        @if($photo->description)
                                            <p class="text-sm opacity-90">{{ $photo->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <!-- Fallback sem fotos -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <p>Nenhuma foto encontrada</p>
            </div>
        @endif
    </div>
</section>

<!-- Gallery Modal -->
<div id="gallery-modal" class="hidden fixed inset-0 bg-black/95 z-50 grid place-items-center p-4 backdrop-blur-sm">
    <div class="relative max-w-6xl w-full max-h-[90vh] flex flex-col">
        <!-- Close Button -->
        <button id="gallery-close-btn" class="absolute -top-12 right-0 text-white text-4xl hover:text-pink-400 transition-colors font-light z-10">&times;</button>
        
        <!-- Modal Content -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-full">
            <!-- Image Container -->
            <div class="flex-1 grid place-items-center bg-gradient-to-br from-pink-50 to-rose-50 p-8">
                <img id="gallery-modal-img" src="" alt="" class="max-w-full max-h-[60vh] object-contain rounded-lg shadow-lg">
            </div>
            
            <!-- Content -->
            <div class="p-8 bg-white border-t border-pink-100">
                <div class="text-center">
                    <h4 id="gallery-modal-title" class="text-3xl font-bold mb-3 text-gray-900"></h4>
                    <p id="gallery-modal-description" class="text-lg text-gray-600 leading-relaxed"></p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Album Modal -->
<div id="album-modal" class="hidden fixed inset-0 z-40">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>
    <!-- Panel -->
    <div class="relative h-full w-full flex items-center justify-center p-4 md:p-8">
        <div class="relative w-full max-w-6xl bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b bg-gradient-to-r from-purple-50 to-pink-50">
                <div>
                    <h3 id="album-modal-title" class="text-xl md:text-2xl font-bold text-gray-900">Álbum</h3>
                    <p id="album-modal-subtitle" class="text-sm text-gray-600"></p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="px-3 py-1.5 text-sm font-medium text-purple-700 hover:text-purple-900 hover:bg-purple-100 rounded-lg hidden md:inline" onclick="closeAlbumModal()">Voltar aos álbuns</button>
                    <button class="w-10 h-10 grid place-items-center rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200" aria-label="Fechar" onclick="closeAlbumModal()">&times;</button>
                </div>
            </div>
            <!-- Body -->
            <div id="album-modal-body" class="p-4 md:p-6 max-h-[70vh] overflow-y-auto">
                <!-- grid injected here -->
            </div>
        </div>
    </div>
</div>


<script>
    function openAlbumModal(id, title){
        const modal = document.getElementById('album-modal');
        const body = document.getElementById('album-modal-body');
        const section = document.getElementById(id);
        if(section && body){
            // Inject grid and enhance items with modal open handlers
            body.innerHTML = section.innerHTML;
            const items = body.querySelectorAll('.gallery-item');
            items.forEach(item => {
                // already wired inline; keep as is
            });
        }
        document.getElementById('album-modal-title').textContent = title || 'Álbum';
        // subtitle with photos count
        const count = section ? section.querySelectorAll('.gallery-item').length : 0;
        const subtitle = document.getElementById('album-modal-subtitle');
        if(subtitle){ subtitle.textContent = count ? `${count} foto${count>1?'s':''}` : ''; }
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        // Close on ESC
        modal._escHandler = (e)=>{ if(e.key==='Escape') closeAlbumModal(); };
        document.addEventListener('keydown', modal._escHandler);
    }
    function closeAlbumModal(){
        const modal = document.getElementById('album-modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        if(modal._escHandler){ document.removeEventListener('keydown', modal._escHandler); modal._escHandler=null; }
    }
    function openPhotoModal(src, title, desc){
        const modal = document.getElementById('gallery-modal');
        document.getElementById('gallery-modal-img').src = src;
        document.getElementById('gallery-modal-title').textContent = title || '';
        document.getElementById('gallery-modal-description').textContent = desc || '';
        modal.classList.remove('hidden');
        document.getElementById('gallery-close-btn').onclick = () => modal.classList.add('hidden');
        modal.addEventListener('click', (e) => { if(e.target === modal) modal.classList.add('hidden'); });
    }
</script>

