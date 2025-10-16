<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['assignedEmployer','employees'])
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
        $profId = auth()->id();
        $employees = Employee::where('professional_id', $profId)->where('active', true)->orderBy('name')->get();
        
        // Checa limite e bloqueia formulário se necessário
        $limits = auth()->user()->planLimits();
        $serviceLimit = (int) ($limits['services'] ?? PHP_INT_MAX);
        if (Service::count() >= $serviceLimit) {
            return redirect()->route('panel.servicos.index')
                ->withErrors(['plan' => 'Você atingiu o limite de serviços do seu plano. Faça upgrade para adicionar mais.']);
        }

        return view('panel.servicos-create', compact('employees'));
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
            'assigned_employer_id' => 'nullable|exists:employees,id',
            'allows_multiple' => 'boolean',
            'employee_ids' => 'nullable|array',
            'employee_ids.*' => 'integer|exists:employees,id',
        ]);

        $service = Service::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'duration' => $validated['duration'],
            'price' => $validated['price'] ?? null,
            'active' => $validated['active'] ?? true,
            'assigned_employer_id' => $validated['assigned_employer_id'] ?? null,
            'allows_multiple' => $validated['allows_multiple'] ?? false,
        ]);

        if (!empty($validated['employee_ids'])) {
            $service->employees()->sync($validated['employee_ids']);
        }

        return redirect()->route('panel.servicos.index')
            ->with('success', 'Serviço criado com sucesso!');
    }

    public function show(Service $servico)
    {
        return view('panel.servicos-show', compact('servico'));
    }

    public function edit(Service $servico)
    {

        $profId = auth()->id();
        $employees = Employee::where('professional_id', $profId)->orderBy('name')->get();

        
        return view('panel.servicos-edit', compact('servico','employees'));
    }

    public function update(Request $request, Service $servico)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'active' => 'boolean',
            'assigned_employer_id' => 'nullable|exists:employees,id',
            'allows_multiple' => 'boolean',
            'employee_ids' => 'nullable|array',
            'employee_ids.*' => 'integer|exists:employees,id',
        ]);

        $servico->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'duration' => $validated['duration'],
            'price' => $validated['price'] ?? null,
            'active' => $validated['active'] ?? $servico->active,
            'assigned_employer_id' => $validated['assigned_employer_id'] ?? null,
            'allows_multiple' => $validated['allows_multiple'] ?? false,
        ]);

        $servico->employees()->sync($validated['employee_ids'] ?? []);

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
