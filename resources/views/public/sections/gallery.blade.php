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
<div id="gallery-modal" class="hidden fixed inset-0 bg-black/90 z-50 items-center justify-center p-4">
    <div class="max-w-5xl w-full">
        <button id="gallery-close-btn" class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300 transition-colors">&times;</button>
        <img id="gallery-modal-img" src="" alt="" class="w-full h-auto max-h-[80vh] object-contain rounded-lg">
        <div class="mt-4 text-center text-white">
            <h4 id="gallery-modal-title" class="text-2xl font-bold mb-2"></h4>
            <p id="gallery-modal-description" class="text-gray-300"></p>
        </div>
    </div>
</div>

