<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogTagController extends Controller
{
    private $professionalId = 1; // Temporário - usar ID fixo como outros controllers

    public function index()
    {
        $tags = BlogTag::where('professional_id', $this->professionalId)
                      ->withCount('posts')
                      ->orderBy('name')
                      ->get();

        return view('panel.blog.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_tags,slug',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'active' => 'boolean',
        ]);

        $validated['professional_id'] = $this->professionalId;
        $validated['active'] = $request->has('active');

        BlogTag::create($validated);

        return redirect()->route('panel.blog.tags.index')
                        ->with('success', 'Tag criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $tag = BlogTag::where('professional_id', $this->professionalId)
                     ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_tags,slug,' . $id,
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->has('active');

        $tag->update($validated);

        return redirect()->route('panel.blog.tags.index')
                        ->with('success', 'Tag atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $tag = BlogTag::where('professional_id', $this->professionalId)
                     ->findOrFail($id);

        $tag->delete();

        return redirect()->route('panel.blog.tags.index')
                        ->with('success', 'Tag excluída com sucesso!');
    }
}