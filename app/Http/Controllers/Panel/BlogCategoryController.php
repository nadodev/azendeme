<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogCategoryController extends Controller
{
    private $professionalId = 1; // Temporário - usar ID fixo como outros controllers


    public function index()
    {
        
        $categories = BlogCategory::where('professional_id', $this->professionalId)
                                 ->withCount('posts')
                                 ->orderBy('sort_order')
                                 ->orderBy('name')
                                 ->get();

        return view('panel.blog.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('panel.blog.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['professional_id'] = $this->professionalId;
        $validated['active'] = $request->has('active');

        BlogCategory::create($validated);

        return redirect()->route('panel.blog.categories.index')
                        ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit($id)
    {
        $category = BlogCategory::where('professional_id', $this->professionalId)
                               ->findOrFail($id);

        return view('panel.blog.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = BlogCategory::where('professional_id', $this->professionalId)
                               ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug,' . $id,
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['active'] = $request->has('active');

        $category->update($validated);

        return redirect()->route('panel.blog.categories.index')
                        ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $category = BlogCategory::where('professional_id', $this->professionalId)
                               ->findOrFail($id);

        // Verificar se há posts usando esta categoria
        if ($category->posts()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Não é possível excluir uma categoria que possui posts. Mova os posts para outra categoria primeiro.');
        }

        $category->delete();

        return redirect()->route('panel.blog.categories.index')
                        ->with('success', 'Categoria excluída com sucesso!');
    }

    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:blog_categories,id',
            'categories.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($validated['categories'] as $categoryData) {
            BlogCategory::where('professional_id', $this->professionalId)
                       ->where('id', $categoryData['id'])
                       ->update(['sort_order' => $categoryData['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}