<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Professional;
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
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $validated['name'],
            'business_name' => $validated['business_name'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'brand_color' => $validated['brand_color'] ?? '#6C63FF',
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
}
