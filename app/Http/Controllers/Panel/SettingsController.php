<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\TemplateSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index()
    {
        $professionalId = 1;
        $professional = Professional::findOrFail($professionalId);

        return view('panel.configuracoes', compact('professional'));
    }

    public function update(Request $request)
    {
        $professionalId = 1;
        $professional = Professional::findOrFail($professionalId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'brand_color' => 'nullable|string|max:7',
            'template' => 'nullable|in:clinic,salon,tattoo,barber',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $validated['name'],
            'business_name' => $validated['business_name'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'brand_color' => $validated['brand_color'] ?? '#6C63FF',
            'template' => $validated['template'] ?? 'clinic',
        ];

        // Upload de logo se fornecido
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        // Gerar slug se o nome mudou
        if ($professional->name !== $validated['name']) {
            $data['slug'] = Str::slug($validated['name']);
        }

        $professional->update($data);

        return redirect()->route('panel.configuracoes.index')
            ->with('success', 'Configurações atualizadas com sucesso!');
    }

    public function customizeTemplate()
    {
        $professionalId = 1;
        $professional = Professional::with('templateSetting')->findOrFail($professionalId);
        
        // Se não existir configuração, criar uma padrão
        if (!$professional->templateSetting) {
            $professional->templateSetting()->create([
                'primary_color' => $professional->brand_color ?? '#8B5CF6',
                'secondary_color' => '#A78BFA',
                'accent_color' => '#7C3AED',
                'background_color' => '#0F0F10',
                'text_color' => '#F5F5F5',
            ]);
            $professional->load('templateSetting');
        }

        return view('panel.template-customize', compact('professional'));
    }

    public function updateTemplate(Request $request)
    {
        $professionalId = 1;
        $professional = Professional::findOrFail($professionalId);

        $validated = $request->validate([
            'primary_color' => 'required|string|max:7',
            'secondary_color' => 'required|string|max:7',
            'accent_color' => 'required|string|max:7',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'hero_badge' => 'nullable|string|max:255',
            'services_title' => 'nullable|string|max:255',
            'services_subtitle' => 'nullable|string',
            'gallery_title' => 'nullable|string|max:255',
            'gallery_subtitle' => 'nullable|string',
            'contact_title' => 'nullable|string|max:255',
            'contact_subtitle' => 'nullable|string',
            'button_style' => 'required|in:rounded,square,pill',
        ]);

        // Adicionar checkboxes manualmente (eles não vêm no request quando desmarcados)
        $validated['show_hero_badge'] = $request->has('show_hero_badge');
        $validated['show_dividers'] = $request->has('show_dividers');

        // DEBUG: Ver o que está sendo salvo (REMOVER DEPOIS)
        // dd($validated);

        $professional->templateSetting()->updateOrCreate(
            ['professional_id' => $professionalId],
            $validated
        );

        return redirect()->route('panel.template.customize')
            ->with('success', 'Template personalizado com sucesso!');
    }
}
