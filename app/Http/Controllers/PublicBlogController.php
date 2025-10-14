<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\BlogComment;
use App\Models\Professional;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    public function index(Request $request, $professionalSlug)
    {
        // Buscar o profissional pelo slug
        $professional = Professional::where('slug', $professionalSlug)->firstOrFail();

        $query = BlogPost::where('professional_id', $professional->id)
                        ->where('status', 'published')
                        ->where('published_at', '<=', now())
                        ->with(['category', 'tags']);

        // Filtros
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('blog_tags.id', $request->tag);
            });
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Posts em destaque (primeiro)
        $featuredPosts = (clone $query)->where('featured', true)
                                      ->orderBy('published_at', 'desc')
                                      ->take(3)
                                      ->get();

        // Posts normais (paginados)
        $posts = $query->orderBy('featured', 'desc') // Posts em destaque primeiro
                      ->orderBy('published_at', 'desc')
                      ->paginate(6);

        $categories = BlogCategory::where('professional_id', $professional->id)
                                 ->where('active', true)
                                 ->orderBy('sort_order')
                                 ->orderBy('name')
                                 ->get();

        $tags = BlogTag::where('professional_id', $professional->id)
                      ->where('active', true)
                      ->orderBy('name')
                      ->get();

        return view('public.blog.index', compact('posts', 'featuredPosts', 'categories', 'tags', 'professional'));
    }

    public function show($professionalSlug, $postSlug)
    {
        // Buscar o profissional pelo slug
        $professional = Professional::where('slug', $professionalSlug)->firstOrFail();

        $post = BlogPost::where('professional_id', $professional->id)
                       ->where('slug', $postSlug)
                       ->where('status', 'published')
                       ->where('published_at', '<=', now())
                       ->with(['category', 'tags', 'approvedComments'])
                       ->firstOrFail();

        // Incrementar visualizações
        $post->incrementViews();

        // Posts relacionados (mesma categoria)
        $relatedPosts = BlogPost::where('professional_id', $professional->id)
                               ->where('status', 'published')
                               ->where('published_at', '<=', now())
                               ->where('category_id', $post->category_id)
                               ->where('id', '!=', $post->id)
                               ->with(['category', 'tags'])
                               ->orderBy('published_at', 'desc')
                               ->limit(3)
                               ->get();

        return view('public.blog.show', compact('post', 'relatedPosts', 'professional'));
    }

    public function category($professionalSlug, $categorySlug)
    {
        // Buscar o profissional pelo slug
        $professional = Professional::where('slug', $professionalSlug)->firstOrFail();

        $category = BlogCategory::where('professional_id', $professional->id)
                               ->where('slug', $categorySlug)
                               ->where('active', true)
                               ->firstOrFail();

        $posts = BlogPost::where('professional_id', $professional->id)
                        ->where('category_id', $category->id)
                        ->where('status', 'published')
                        ->where('published_at', '<=', now())
                        ->with(['category', 'tags'])
                        ->orderBy('published_at', 'desc')
                        ->paginate(6);

        return view('public.blog.category', compact('category', 'posts', 'professional'));
    }

    public function tag($professionalSlug, $tagSlug)
    {
        // Buscar o profissional pelo slug
        $professional = Professional::where('slug', $professionalSlug)->firstOrFail();

        $tag = BlogTag::where('professional_id', $professional->id)
                     ->where('slug', $tagSlug)
                     ->where('active', true)
                     ->firstOrFail();

        $posts = BlogPost::where('professional_id', $professional->id)
                        ->where('status', 'published')
                        ->where('published_at', '<=', now())
                        ->whereHas('tags', function ($q) use ($tag) {
                            $q->where('blog_tags.id', $tag->id);
                        })
                        ->with(['category', 'tags'])
                        ->orderBy('published_at', 'desc')
                        ->paginate(6);

        return view('public.blog.tag', compact('tag', 'posts', 'professional'));
    }

    public function storeComment(Request $request, $professionalSlug, $postSlug)
    {
        // Buscar o profissional pelo slug
        $professional = Professional::where('slug', $professionalSlug)->firstOrFail();

        $post = BlogPost::where('professional_id', $professional->id)
                       ->where('slug', $postSlug)
                       ->where('status', 'published')
                       ->where('allow_comments', true)
                       ->firstOrFail();

        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:blog_comments,id',
        ]);

        $validated['post_id'] = $post->id;
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();

        BlogComment::create($validated);

        return redirect()->back()->with('success', 'Comentário enviado com sucesso! Aguarde aprovação.');
    }
}
