<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\FeedbackRequest;
use Illuminate\Http\Request;

class FeedbackManagementController extends Controller
{
    protected $professionalId = 1;

    public function index()
    {
        $feedbacks = Feedback::where('professional_id', $this->professionalId)
            ->with(['customer', 'service', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingCount = $feedbacks->where('approved', false)->count();
        $approvedCount = $feedbacks->where('approved', true)->count();
        $publicCount = $feedbacks->where('visible_public', true)->count();

        return view('panel.feedbacks.index', compact('feedbacks', 'pendingCount', 'approvedCount', 'publicCount'));
    }

    public function approve($id)
    {
        $feedback = Feedback::where('professional_id', $this->professionalId)
            ->findOrFail($id);

        $feedback->update(['approved' => true]);

        return redirect()->back()
            ->with('success', 'Feedback aprovado com sucesso!');
    }

    public function toggleVisibility($id)
    {
        $feedback = Feedback::where('professional_id', $this->professionalId)
            ->findOrFail($id);

        $feedback->update(['visible_public' => !$feedback->visible_public]);

        $message = $feedback->visible_public 
            ? 'Feedback agora está visível na página pública!' 
            : 'Feedback ocultado da página pública!';

        return redirect()->back()
            ->with('success', $message);
    }

    public function destroy($id)
    {
        $feedback = Feedback::where('professional_id', $this->professionalId)
            ->findOrFail($id);

        $feedback->delete();

        return redirect()->back()
            ->with('success', 'Feedback excluído com sucesso!');
    }
}

