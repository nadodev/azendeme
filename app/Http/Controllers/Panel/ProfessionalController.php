<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfessionalController extends Controller
{
    protected $mainProfessionalId = 1;

    /**
     * Lista todos os profissionais da equipe
     */
    public function index()
    {
        // Busca todos os profissionais (por enquanto sistema single-tenant)
        $professionals = Professional::orderBy('is_main', 'desc')
            ->orderBy('name')
            ->get();

        return view('panel.professionals.index', compact('professionals'));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        return view('panel.professionals.create');
    }

    /**
     * Salva novo profissional
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:professionals,email',
            'phone' => 'nullable|string|max:20',
            'specialty' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Upload de foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('professionals', 'public');
        }

        // Criar profissional
        $professional = Professional::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'specialty' => $validated['specialty'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'commission_percentage' => $validated['commission_percentage'] ?? 0,
            'photo' => $photoPath,
            'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
            'is_main' => false,
            'brand_color' => '#8B5CF6',
            'template' => 'clinic',
        ]);

        return redirect()->route('panel.professionals.index')
            ->with('success', 'Profissional cadastrado com sucesso!');
    }

    /**
     * Formulário de edição
     */
    public function edit($id)
    {
        $professional = Professional::findOrFail($id);
        return view('panel.professionals.edit', compact('professional'));
    }

    /**
     * Atualiza profissional
     */
    public function update(Request $request, $id)
    {
        $professional = Professional::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:professionals,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'specialty' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Upload de nova foto
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('professionals', 'public');
            $validated['photo'] = $photoPath;
        }

        $professional->update($validated);

        return redirect()->route('panel.professionals.index')
            ->with('success', 'Profissional atualizado com sucesso!');
    }

    /**
     * Remove profissional
     */
    public function destroy($id)
    {
        $professional = Professional::findOrFail($id);

        if ($professional->is_main) {
            return redirect()->back()
                ->with('error', 'Não é possível excluir o profissional principal!');
        }

        $professional->delete();

        return redirect()->route('panel.professionals.index')
            ->with('success', 'Profissional removido com sucesso!');
    }
}

