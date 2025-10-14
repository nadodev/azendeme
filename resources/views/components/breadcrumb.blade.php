@props(['items' => []])

@php
    // Se não foram passados itens, usar o helper para gerar automaticamente
    if (empty($items)) {
        $items = \App\Helpers\BreadcrumbHelper::generate();
    }
@endphp

@if(!empty($items))
<nav class="bg-white border-b border-gray-200" aria-label="Breadcrumb">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-3">
            <!-- Breadcrumb Items -->
            <div class="flex items-center space-x-2 min-w-0 flex-1">
                <!-- Home Icon -->
                <a href="{{ route('panel.dashboard') }}" class="text-gray-400 hover:text-gray-500 transition-colors flex-shrink-0" aria-label="Dashboard">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                </a>
                
                <!-- Breadcrumb Path -->
                <div class="flex items-center space-x-1 overflow-x-auto scrollbar-hide">
                    @foreach($items as $label => $url)
                        @if(!$loop->first)
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                        
                        @if($url && !$loop->last)
                            <a href="{{ $url }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors whitespace-nowrap px-1 py-0.5 rounded hover:bg-gray-100">
                                {{ $label }}
                            </a>
                        @else
                            <span class="text-sm font-medium text-gray-900 whitespace-nowrap px-1 py-0.5 bg-gray-50 rounded">
                                {{ $label }}
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>
            
            <!-- Mobile Menu Button (Hidden on larger screens) -->
            <div class="flex-shrink-0 lg:hidden">
                <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500" onclick="toggleMobileBreadcrumb()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Breadcrumb (Hidden by default) -->
        <div id="mobile-breadcrumb" class="hidden lg:hidden pb-3 border-t border-gray-100">
            <div class="flex flex-col space-y-2 pt-3">
                @foreach($items as $label => $url)
                    @if($url && !$loop->last)
                        <a href="{{ $url }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors px-2 py-1 rounded hover:bg-gray-100">
                            {{ $label }}
                        </a>
                    @else
                        <span class="text-sm font-medium text-gray-900 px-2 py-1 bg-gray-50 rounded">
                            {{ $label }}
                        </span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</nav>

<style>
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>

<script>
function toggleMobileBreadcrumb() {
    const mobileBreadcrumb = document.getElementById('mobile-breadcrumb');
    if (mobileBreadcrumb) {
        mobileBreadcrumb.classList.toggle('hidden');
    }
}
</script>
@endif
