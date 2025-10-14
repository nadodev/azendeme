<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogCommentController extends Controller
{
    private $professionalId = 1; // Temporário - usar ID fixo como outros controllers

    public function index()
    {
        $comments = BlogComment::whereHas('post', function ($query) {
                                 $query->where('professional_id', $this->professionalId);
                             })
                             ->with(['post'])
                             ->orderBy('created_at', 'desc')
                             ->paginate(20);

        $posts = BlogPost::where('professional_id', $this->professionalId)
                         ->orderBy('title')
                         ->get();

        $stats = [
            'total' => BlogComment::whereHas('post', function ($query) {
                                    $query->where('professional_id', $this->professionalId);
                                })->count(),
            'pending' => BlogComment::whereHas('post', function ($query) {
                                      $query->where('professional_id', $this->professionalId);
                                  })->where('status', 'pending')->count(),
            'approved' => BlogComment::whereHas('post', function ($query) {
                                       $query->where('professional_id', $this->professionalId);
                                   })->where('status', 'approved')->count(),
            'rejected' => BlogComment::whereHas('post', function ($query) {
                                      $query->where('professional_id', $this->professionalId);
                                  })->where('status', 'rejected')->count(),
        ];

        return view('panel.blog.comments.index', compact('comments', 'posts', 'stats'));
    }

    public function show($id)
    {
        $comment = BlogComment::whereHas('post', function ($query) {
                              $query->where('professional_id', $this->professionalId);
                          })
                          ->with(['post', 'replies'])
                          ->findOrFail($id);

        return view('panel.blog.comments.show', compact('comment'));
    }

    public function approve($id)
    {
        $comment = BlogComment::whereHas('post', function ($query) {
                              $query->where('professional_id', $this->professionalId);
                          })
                          ->findOrFail($id);

        $comment->approve();

        return redirect()->back()
                        ->with('success', 'Comentário aprovado com sucesso!');
    }

    public function reject($id)
    {
        $comment = BlogComment::whereHas('post', function ($query) {
                              $query->where('professional_id', $this->professionalId);
                          })
                          ->findOrFail($id);

        $comment->reject();

        return redirect()->back()
                        ->with('success', 'Comentário rejeitado com sucesso!');
    }

    public function destroy($id)
    {
        $comment = BlogComment::whereHas('post', function ($query) {
                              $query->where('professional_id', $this->professionalId);
                          })
                          ->findOrFail($id);

        $comment->delete();

        return redirect()->route('panel.blog.comments.index')
                        ->with('success', 'Comentário excluído com sucesso!');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:blog_comments,id',
        ]);

        $comments = BlogComment::whereHas('post', function ($query) {
                              $query->where('professional_id', $this->professionalId);
                          })
                          ->whereIn('id', $validated['comment_ids'])
                          ->get();

        foreach ($comments as $comment) {
            switch ($validated['action']) {
                case 'approve':
                    $comment->approve();
                    break;
                case 'reject':
                    $comment->reject();
                    break;
                case 'delete':
                    $comment->delete();
                    break;
            }
        }

        $actionText = [
            'approve' => 'aprovados',
            'reject' => 'rejeitados',
            'delete' => 'excluídos'
        ];

        return redirect()->back()
                        ->with('success', count($comments) . ' comentários ' . $actionText[$validated['action']] . ' com sucesso!');
    }
}