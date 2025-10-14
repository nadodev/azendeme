<?php

namespace App\Http\Controllers;

use App\Models\{FeedbackRequest, Feedback};
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Exibe o formulário de feedback
     */
    public function show($token)
    {
        $feedbackRequest = FeedbackRequest::where('token', $token)
            ->with(['professional', 'customer', 'service', 'appointment'])
            ->firstOrFail();

        // Verificar se já foi respondido
        if ($feedbackRequest->status === 'completed') {
            return view('feedback.already-completed');
        }

        // Verificar se expirou
        if (!$feedbackRequest->isValid()) {
            return view('feedback.expired');
        }

        return view('feedback.form', compact('feedbackRequest'));
    }

    /**
     * Processa o envio do feedback
     */
    public function store(Request $request, $token)
    {
        $feedbackRequest = FeedbackRequest::where('token', $token)->firstOrFail();

        // Verificar se ainda é válido
        if (!$feedbackRequest->isValid()) {
            return redirect()->route('feedback.show', $token)
                ->with('error', 'Este link de feedback expirou.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'what_liked' => 'nullable|string|max:500',
            'what_improve' => 'nullable|string|max:500',
            'would_recommend' => 'boolean',
        ]);

        // Criar feedback (aguardando aprovação do admin)
        $feedback = Feedback::create([
            'professional_id' => $feedbackRequest->professional_id,
            'feedback_request_id' => $feedbackRequest->id,
            'appointment_id' => $feedbackRequest->appointment_id,
            'customer_id' => $feedbackRequest->customer_id,
            'service_id' => $feedbackRequest->service_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'what_liked' => $validated['what_liked'] ?? null,
            'what_improve' => $validated['what_improve'] ?? null,
            'would_recommend' => $validated['would_recommend'] ?? true,
            'visible_public' => false,  // Não visível até admin aprovar
            'approved' => false,         // Aguardando aprovação
        ]);

        // Marcar solicitação como concluída
        $feedbackRequest->markAsCompleted();

        return view('feedback.success', compact('feedback', 'feedbackRequest'));
    }
}
