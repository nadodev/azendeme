<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\TemplateSetting;
use App\Helpers\TemplateColors;
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
        
        // Se não existir configuração, criar uma padrão baseada no template
        if (!$professional->templateSetting) {
            $template = $professional->template ?? 'clinic';
            $defaultColors = TemplateColors::getDefaults($template, $professional->brand_color);
            $professional->templateSetting()->create($defaultColors);
            $professional->load('templateSetting');
        }

        $templateInfo = [
            'name' => $professional->template ?? 'clinic',
            'description' => TemplateColors::getTemplateDescription($professional->template ?? 'clinic'),
            'colorNames' => TemplateColors::getColorNames()
        ];

        return view('panel.template-customize', compact('professional', 'templateInfo'));
    }

    public function updateTemplate(Request $request)
    {
        $professionalId = 1;
        $professional = Professional::findOrFail($professionalId);

        $validated = $request->validate([
            // Cores globais (opcionais para compatibilidade)
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'accent_color' => 'required|string|max:7',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            
            // Cores por seção
            'hero_primary_color' => 'required|string|max:7',
            'hero_background_color' => 'required|string|max:7',
            'services_primary_color' => 'required|string|max:7',
            'services_background_color' => 'required|string|max:7',
            'gallery_primary_color' => 'required|string|max:7',
            'gallery_background_color' => 'required|string|max:7',
            'booking_primary_color' => 'required|string|max:7',
            'booking_background_color' => 'required|string|max:7',
            
            // Imagens
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'remove_about_image' => 'nullable|boolean',
            
            // Textos
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
        
        // Definir valores padrão para campos opcionais
        $validated['primary_color'] = $validated['primary_color'] ?? $validated['hero_primary_color'];
        $validated['secondary_color'] = $validated['secondary_color'] ?? $validated['services_primary_color'];

        // Processar upload da imagem da seção Sobre Nós
        if ($request->hasFile('about_image')) {
            // Remove imagem anterior se existir
            $currentSetting = $professional->templateSetting;
            if ($currentSetting && $currentSetting->about_image) {
                $oldImagePath = storage_path('app/public/' . $currentSetting->about_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            // Salva nova imagem
            $imagePath = $request->file('about_image')->store('about-images', 'public');
            $validated['about_image'] = $imagePath;
        } elseif ($request->has('remove_about_image')) {
            // Remove imagem atual
            $currentSetting = $professional->templateSetting;
            if ($currentSetting && $currentSetting->about_image) {
                $oldImagePath = storage_path('app/public/' . $currentSetting->about_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $validated['about_image'] = null;
        } else {
            // Mantém imagem existente se não houver upload nem remoção
            unset($validated['about_image']);
        }

        $professional->templateSetting()->updateOrCreate(
            ['professional_id' => $professionalId],
            $validated
        );

        return redirect()->route('panel.template.customize')
            ->with('success', 'Template personalizado com sucesso!');
    }
}
