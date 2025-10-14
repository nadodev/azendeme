<!-- Galeria -->
<section id="galeria" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Galeria</h3>
            <p class="text-gray-600 text-lg">Veja alguns dos nossos trabalhos</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($gallery as $photo)
                <div class="gallery-item relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all cursor-pointer">
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
            @empty
                @for($i = 1; $i <= 6; $i++)
                    <div class="gallery-item relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all cursor-pointer">
                        <img src="https://picsum.photos/400/300?random={{ $i }}" alt="Trabalho {{ $i }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            <div class="text-white">
                                <h5 class="font-bold">Nosso Trabalho</h5>
                                <p class="text-sm opacity-90">Qualidade e dedicação</p>
                            </div>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>
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

