<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $professionalId = auth()->user()->id;
        $employees = Employee::where('professional_id', $professionalId)->orderBy('name')->get();
        return view('panel.employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $professionalId = optional(auth()->user()->professional)->id ?? auth()->user()->id;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'color' => 'nullable|string|max:20',
            'active' => 'nullable|boolean',
            'show_in_booking' => 'nullable|boolean',
        ]);

        $employee = Employee::create([
            'professional_id' => $professionalId,
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'color' => $validated['color'] ?? null,
            'active' => (bool)($validated['active'] ?? true),
            'show_in_booking' => (bool)($validated['show_in_booking'] ?? false),
        ]);

        // Vinculação de serviços é feita na tela de serviços

        return redirect()->route('panel.employees.index')->with('success', 'Funcionário criado com sucesso.');
    }

    public function update(Request $request, Employee $employee)
    {
        if ($employee->professional_id !== auth()->user()->id) abort(403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'color' => 'nullable|string|max:20',
            'active' => 'nullable|boolean',
        ]);

        $employee->update([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'color' => $validated['color'] ?? null,
            'active' => (bool)($validated['active'] ?? true),
            'show_in_booking' => (bool)($validated['show_in_booking'] ?? false),
        ]);
        // Vinculação de serviços é feita na tela de serviços

        return redirect()->route('panel.employees.index')->with('success', 'Funcionário atualizado.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->professional_id !== auth()->user()->id) abort(403);
        $employee->services()->detach();
        $employee->delete();
        return redirect()->route('panel.employees.index')->with('success', 'Funcionário removido.');
    }
}


