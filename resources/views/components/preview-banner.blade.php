@if(isset($isPreview) && $isPreview)
<div class="fixed top-0 left-0 right-0 z-[9999] bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 shadow-2xl">
    <div class="container mx-auto flex items-center justify-between flex-wrap gap-2">
        <div class="flex items-center gap-3">
            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-3 py-1">
                <span class="font-bold text-sm uppercase tracking-wide">👁️ Modo Preview</span>
            </div>
            <span class="text-sm">
                Você está visualizando o template: 
                <strong class="font-bold uppercase">{{ ucfirst(str_replace(['-', '_'], ' ', $template ?? 'clinic')) }}</strong>
            </span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('panel.template.select') }}" class="bg-white text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg font-semibold text-sm transition-colors">
                ← Voltar para Seleção
            </a>
            <form action="{{ route('panel.template.apply') }}" method="POST" class="inline-block">
                @csrf
                <input type="hidden" name="template" value="{{ $template ?? 'clinic' }}">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors">
                    ✓ Aplicar Este Template
                </button>
            </form>
        </div>
    </div>
</div>
<!-- Spacer para compensar o banner fixo -->
<div class="h-16"></div>
@endif

