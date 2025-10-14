<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    private $professionalId = 1; // Temporário

    public function index()
    {
        $seoSettings = SeoSetting::where('professional_id', $this->professionalId)
                                 ->orderBy('page_type')
                                 ->get();

        $pageTypes = [
            'home' => 'Página Inicial',
            'about' => 'Sobre Nós',
            'services' => 'Serviços',
            'contact' => 'Contato',
            'blog' => 'Blog',
            'appointment' => 'Agendamento',
            'team' => 'Equipe',
        ];

        return view('panel.seo.index', compact('seoSettings', 'pageTypes'));
    }

    public function edit($pageType)
    {
        $seoSetting = SeoSetting::getOrCreateForPage($this->professionalId, $pageType);
        
        $pageTypes = [
            'home' => 'Página Inicial',
            'about' => 'Sobre Nós',
            'services' => 'Serviços',
            'contact' => 'Contato',
            'blog' => 'Blog',
            'appointment' => 'Agendamento',
            'team' => 'Equipe',
        ];

        return view('panel.seo.edit', compact('seoSetting', 'pageTypes'));
    }

    public function update(Request $request, $pageType)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:60',
            'description' => 'nullable|string|max:160',
            'keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:60',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|string|max:255',
            'twitter_title' => 'nullable|string|max:60',
            'twitter_description' => 'nullable|string|max:160',
            'twitter_image' => 'nullable|string|max:255',
            'custom_head' => 'nullable|string',
            'custom_footer' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'noindex' => 'boolean',
            'nofollow' => 'boolean',
        ]);

        $seoSetting = SeoSetting::getOrCreateForPage($this->professionalId, $pageType);
        $seoSetting->update($validated);

        return redirect()->route('panel.seo.index')
                        ->with('success', 'Configurações de SEO atualizadas com sucesso!');
    }

    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.page_type' => 'required|string',
            'settings.*.title' => 'nullable|string|max:60',
            'settings.*.description' => 'nullable|string|max:160',
            'settings.*.keywords' => 'nullable|string|max:255',
        ]);

        foreach ($validated['settings'] as $setting) {
            $seoSetting = SeoSetting::getOrCreateForPage($this->professionalId, $setting['page_type']);
            $seoSetting->update([
                'title' => $setting['title'] ?? '',
                'description' => $setting['description'] ?? '',
                'keywords' => $setting['keywords'] ?? '',
            ]);
        }

        return redirect()->route('panel.seo.index')
                        ->with('success', 'Configurações de SEO atualizadas em lote!');
    }
}