<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    private $professionalId = 1; // Temporário

    public function index()
    {

        $posts = BlogPost::where('professional_id', $this->professionalId)
                        ->with(['category', 'tags'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);

        $stats = [
            'total' => BlogPost::where('professional_id', $this->professionalId)->count(),
            'published' => BlogPost::where('professional_id', $this->professionalId)
                                 ->where('status', 'published')->count(),
            'draft' => BlogPost::where('professional_id', $this->professionalId)
                              ->where('status', 'draft')->count(),
            'scheduled' => BlogPost::where('professional_id', $this->professionalId)
                                  ->where('status', 'scheduled')->count(),
        ];

        return view('panel.blog.index', compact('posts', 'stats'));
    }

    public function create()
    {
        $categories = BlogCategory::where('professional_id', $this->professionalId)
                                 ->where('active', true)
                                 ->orderBy('name')
                                 ->get();

        $tags = BlogTag::where('professional_id', $this->professionalId)
                      ->where('active', true)
                      ->orderBy('name')
                      ->get();

        return view('panel.blog.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:blog_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'status' => 'required|in:draft,published,scheduled',
            'featured' => 'boolean',
            'allow_comments' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_data' => 'nullable|array',
        ]);

        $validated['professional_id'] = $this->professionalId;
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = BlogPost::create($validated);

        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('panel.blog.index')
                        ->with('success', 'Post criado com sucesso!');
    }

    public function show($id)
    {
        $post = BlogPost::where('professional_id', $this->professionalId)
                       ->with(['category', 'tags', 'comments'])
                       ->findOrFail($id);

        return view('panel.blog.show', compact('post'));
    }

    public function edit($id)
    {
        $post = BlogPost::where('professional_id', $this->professionalId)
                       ->with(['tags'])
                       ->findOrFail($id);

        $categories = BlogCategory::where('professional_id', $this->professionalId)
                                 ->where('active', true)
                                 ->orderBy('name')
                                 ->get();

        $tags = BlogTag::where('professional_id', $this->professionalId)
                      ->where('active', true)
                      ->orderBy('name')
                      ->get();

        return view('panel.blog.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $post = BlogPost::where('professional_id', $this->professionalId)->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug,' . $id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'category_id' => 'nullable|exists:blog_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'status' => 'required|in:draft,published,scheduled',
            'featured' => 'boolean',
            'allow_comments' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_data' => 'nullable|array',
            'remove_current_image' => 'nullable|boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Lidar com upload de imagem
        if ($request->hasFile('featured_image')) {
            // Remover imagem anterior se existir
            if ($post->featured_image && file_exists(public_path('storage/' . $post->featured_image))) {
                unlink(public_path('storage/' . $post->featured_image));
            }
            
            $image = $request->file('featured_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('blog/images', $imageName, 'public');
            $validated['featured_image'] = $imagePath;
        } elseif ($request->has('remove_current_image')) {
            // Remover imagem atual se solicitado
            if ($post->featured_image && file_exists(public_path('storage/' . $post->featured_image))) {
                unlink(public_path('storage/' . $post->featured_image));
            }
            $validated['featured_image'] = null;
        } else {
            // Manter imagem atual
            unset($validated['featured_image']);
        }

        $post->update($validated);

        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('panel.blog.index')
                        ->with('success', 'Post atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $post = BlogPost::where('professional_id', $this->professionalId)->findOrFail($id);
        $post->delete();

        return redirect()->route('panel.blog.index')
                        ->with('success', 'Post excluído com sucesso!');
    }

    public function toggleStatus($id)
    {
        $post = BlogPost::where('professional_id', $this->professionalId)->findOrFail($id);
        
        $newStatus = $post->status === 'published' ? 'draft' : 'published';
        $post->update([
            'status' => $newStatus,
            'published_at' => $newStatus === 'published' ? now() : null
        ]);

        return redirect()->back()
                        ->with('success', 'Status do post alterado com sucesso!');
    }

    public function toggleFeatured($id)
    {
        $post = BlogPost::where('professional_id', $this->professionalId)->findOrFail($id);
        $post->update(['featured' => !$post->featured]);

        return redirect()->back()
                        ->with('success', 'Status de destaque alterado com sucesso!');
    }
}