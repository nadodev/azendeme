<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Professional;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $professionalId = 1;
        $services = Service::where('professional_id', $professionalId)
            ->with('assignedProfessional')
            ->orderBy('name')
            ->get();

        return view('panel.servicos', compact('services'));
    }

    public function create()
    {
        // Busca todos os profissionais disponíveis
        $professionals = Professional::orderBy('is_main', 'desc')
            ->orderBy('name')
            ->get();
        
        return view('panel.servicos-create', compact('professionals'));
    }

    public function store(Request $request)
    {
        $professionalId = 1;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'active' => 'boolean',
            'assigned_professional_id' => 'nullable|exists:professionals,id',
            'allows_multiple' => 'boolean',
        ]);

        Service::create([
            'professional_id' => $professionalId,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'duration' => $validated['duration'],
            'price' => $validated['price'] ?? null,
            'active' => $validated['active'] ?? true,
            'assigned_professional_id' => $validated['assigned_professional_id'] ?? null,
            'allows_multiple' => $validated['allows_multiple'] ?? false,
        ]);

        return redirect()->route('panel.servicos.index')
            ->with('success', 'Serviço criado com sucesso!');
    }

    public function show(Service $servico)
    {
        return view('panel.servicos-show', compact('servico'));
    }

    public function edit(Service $servico)
    {
        // Busca todos os profissionais disponíveis
        $professionals = Professional::orderBy('is_main', 'desc')
            ->orderBy('name')
            ->get();
        
        return view('panel.servicos-edit', compact('servico', 'professionals'));
    }

    public function update(Request $request, Service $servico)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'active' => 'boolean',
            'assigned_professional_id' => 'nullable|exists:professionals,id',
            'allows_multiple' => 'boolean',
        ]);

        $servico->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'duration' => $validated['duration'],
            'price' => $validated['price'] ?? null,
            'active' => $validated['active'] ?? $servico->active,
            'assigned_professional_id' => $validated['assigned_professional_id'] ?? null,
            'allows_multiple' => $validated['allows_multiple'] ?? false,
        ]);

        return redirect()->route('panel.servicos.index')
            ->with('success', 'Serviço atualizado com sucesso!');
    }

    public function destroy(Service $servico)
    {
        $servico->delete();
        return redirect()->route('panel.servicos.index')
            ->with('success', 'Serviço excluído com sucesso!');
    }
}
