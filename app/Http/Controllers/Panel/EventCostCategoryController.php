<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\EventCostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventCostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        $categories = EventCostCategory::where('professional_id', $professional->id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('panel.events.cost-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        return view('panel.events.cost-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        EventCostCategory::create([
            'professional_id' => $professional->id,
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('panel.events.cost-categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventCostCategory $costCategory)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($costCategory->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $costs = $costCategory->costs()
            ->with(['event.customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('panel.events.cost-categories.show', compact('costCategory', 'costs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventCostCategory $costCategory)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($costCategory->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        return view('panel.events.cost-categories.edit', compact('costCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventCostCategory $costCategory)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($costCategory->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $costCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('panel.events.cost-categories.show', $costCategory)
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventCostCategory $costCategory)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($costCategory->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        // Verificar se há custos associados
        if ($costCategory->costs()->count() > 0) {
            return back()->with('error', 'Não é possível excluir uma categoria que possui custos associados.');
        }

        $costCategory->delete();

        return redirect()->route('panel.events.cost-categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}