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
        $services = Service::with('assignedProfessional')
            ->orderBy('name')
            ->get();

        // Flag de limite para desabilitar botão
        $limits = auth()->user()->planLimits();
        $serviceLimit = (int) ($limits['services'] ?? PHP_INT_MAX);
        $reachedLimit = Service::count() >= $serviceLimit;

        return view('panel.servicos', compact('services', 'reachedLimit'));
    }

    public function create()
    {
        $professionals = Professional::where('user_id', auth()->id())
            ->orderBy('is_main', 'desc')
            ->orderBy('name')
            ->get();
        
        // Checa limite e bloqueia formulário se necessário
        $limits = auth()->user()->planLimits();
        $serviceLimit = (int) ($limits['services'] ?? PHP_INT_MAX);
        if (Service::count() >= $serviceLimit) {
            return redirect()->route('panel.servicos.index')
                ->withErrors(['plan' => 'Você atingiu o limite de serviços do seu plano. Faça upgrade para adicionar mais.']);
        }

        return view('panel.servicos-create', compact('professionals'));
    }

    public function store(Request $request)
    {
        // Enforce limite
        $limits = auth()->user()->planLimits();
        $serviceLimit = (int) ($limits['services'] ?? PHP_INT_MAX);
        if (Service::count() >= $serviceLimit) {
            return redirect()->route('panel.servicos.index')
                ->withErrors(['plan' => 'Você atingiu o limite de serviços do seu plano. Faça upgrade para adicionar mais.']);
        }

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
        $professionals = Professional::where('user_id', auth()->id())
            ->orderBy('is_main', 'desc')
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
