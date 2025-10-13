<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $professionalId = 1;
        
        $search = $request->get('search');

        $query = Customer::where('professional_id', $professionalId)
            ->withCount('appointments');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('name')->get();

        return view('panel.clientes', compact('customers'));
    }

    public function create()
    {
        return view('panel.clientes-create');
    }

    public function store(Request $request)
    {
        $professionalId = 1;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string',
        ]);

        Customer::create([
            'professional_id' => $professionalId,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('panel.clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(Customer $cliente)
    {
        $cliente->load(['appointments' => function($query) {
            $query->with('service')->orderBy('start_time', 'desc');
        }]);

        return view('panel.clientes-show', compact('cliente'));
    }

    public function edit(Customer $cliente)
    {
        return view('panel.clientes-edit', compact('cliente'));
    }

    public function update(Request $request, Customer $cliente)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string',
        ]);

        $cliente->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('panel.clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Customer $cliente)
    {
        $cliente->delete();
        return redirect()->route('panel.clientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }
}
