<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $professionalId = 1;
        $services = Service::where('professional_id', $professionalId)
            ->orderBy('name')
            ->get();

        return view('panel.servicos', compact('services'));
    }

    public function create()
    {
        return view('panel.servicos-create');
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
        ]);

        Service::create([
            'professional_id' => $professionalId,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'duration' => $validated['duration'],
            'price' => $validated['price'] ?? null,
            'active' => $validated['active'] ?? true,
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
        return view('panel.servicos-edit', compact('servico'));
    }

    public function update(Request $request, Service $servico)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'active' => 'boolean',
        ]);

        $servico->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'duration' => $validated['duration'],
            'price' => $validated['price'] ?? null,
            'active' => $validated['active'] ?? $servico->active,
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
