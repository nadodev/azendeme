<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\EmailCampaign;
use App\Models\EmailTemplate;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmailMarketingController extends Controller
{
    private int $professionalId = 1; // Hardcoded por enquanto

    /**
     * Dashboard de E-mail Marketing
     */
    public function index(Request $request): View
    {
        $query = EmailCampaign::forProfessional($this->professionalId)
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        $campaigns = $query->paginate(10);

        // Estatísticas
        $stats = [
            'total_campaigns' => EmailCampaign::forProfessional($this->professionalId)->count(),
            'sent_campaigns' => EmailCampaign::forProfessional($this->professionalId)->byStatus('sent')->count(),
            'scheduled_campaigns' => EmailCampaign::forProfessional($this->professionalId)->byStatus('scheduled')->count(),
            'total_recipients' => EmailCampaign::forProfessional($this->professionalId)->sum('total_recipients'),
            'total_sent' => EmailCampaign::forProfessional($this->professionalId)->sum('sent_count'),
            'total_opened' => EmailCampaign::forProfessional($this->professionalId)->sum('opened_count'),
            'total_clicked' => EmailCampaign::forProfessional($this->professionalId)->sum('clicked_count'),
        ];

        // Calcular taxas médias
        $stats['avg_delivery_rate'] = $stats['total_recipients'] > 0 
            ? round((EmailCampaign::forProfessional($this->professionalId)->sum('delivered_count') / $stats['total_recipients']) * 100, 2)
            : 0;
        
        $stats['avg_open_rate'] = $stats['total_sent'] > 0 
            ? round(($stats['total_opened'] / $stats['total_sent']) * 100, 2)
            : 0;

        $stats['avg_click_rate'] = $stats['total_sent'] > 0 
            ? round(($stats['total_clicked'] / $stats['total_sent']) * 100, 2)
            : 0;

        return view('panel.email-marketing.index', compact('campaigns', 'stats'));
    }

    /**
     * Criar nova campanha
     */
    public function create(): View
    {
        $templates = EmailTemplate::forProfessional($this->professionalId)
            ->active()
            ->orderBy('name')
            ->get();

        $services = Service::where('professional_id', $this->professionalId)
            ->where('active', true)
            ->orderBy('name')
            ->get();

        return view('panel.email-marketing.create', compact('templates', 'services'));
    }

    /**
     * Salvar nova campanha
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'text_content' => 'nullable|string',
            'type' => 'required|in:newsletter,promotion,reminder,follow_up,custom',
            'target_criteria' => 'nullable|array',
            'schedule_settings' => 'nullable|array',
            'scheduled_at' => 'nullable|date|after:now',
            'notes' => 'nullable|string',
        ]);

        $validated['professional_id'] = $this->professionalId;
        $validated['status'] = $request->has('scheduled_at') ? 'scheduled' : 'draft';

        // Calcular destinatários baseados nos critérios
        $campaign = new EmailCampaign($validated);
        $recipients = $campaign->getTargetRecipients();
        $validated['total_recipients'] = $recipients->count();

        $campaign = EmailCampaign::create($validated);

        // Criar registros de destinatários
        foreach ($recipients as $customer) {
            $campaign->recipients()->create([
                'customer_id' => $customer->id,
                'email' => $customer->email,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('panel.email-marketing.index')
            ->with('success', 'Campanha criada com sucesso!');
    }

    /**
     * Exibir campanha
     */
    public function show(EmailCampaign $emailCampaign): View
    {
        // Verificar se a campanha pertence ao profissional
        if ($emailCampaign->professional_id !== $this->professionalId) {
            abort(403, 'Acesso negado');
        }

        $emailCampaign->load(['recipients.customer']);

        return view('panel.email-marketing.show', compact('emailCampaign'));
    }

    /**
     * Editar campanha
     */
    public function edit(EmailCampaign $emailCampaign): View
    {
        // Verificar se a campanha pertence ao profissional
        if ($emailCampaign->professional_id !== $this->professionalId) {
            abort(403, 'Acesso negado');
        }

        if (!$emailCampaign->canBeEdited()) {
            return redirect()->route('panel.email-marketing.show', $emailCampaign)
                ->with('error', 'Esta campanha não pode ser editada.');
        }

        $templates = EmailTemplate::forProfessional($this->professionalId)
            ->active()
            ->orderBy('name')
            ->get();

        $services = Service::where('professional_id', $this->professionalId)
            ->where('active', true)
            ->orderBy('name')
            ->get();

        return view('panel.email-marketing.edit', compact('emailCampaign', 'templates', 'services'));
    }

    /**
     * Atualizar campanha
     */
    public function update(Request $request, EmailCampaign $emailCampaign): RedirectResponse
    {
        // Verificar se a campanha pertence ao profissional
        if ($emailCampaign->professional_id !== $this->professionalId) {
            abort(403, 'Acesso negado');
        }

        if (!$emailCampaign->canBeEdited()) {
            return redirect()->route('panel.email-marketing.show', $emailCampaign)
                ->with('error', 'Esta campanha não pode ser editada.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'text_content' => 'nullable|string',
            'type' => 'required|in:newsletter,promotion,reminder,follow_up,custom',
            'target_criteria' => 'nullable|array',
            'schedule_settings' => 'nullable|array',
            'scheduled_at' => 'nullable|date|after:now',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = $request->has('scheduled_at') ? 'scheduled' : 'draft';

        // Recalcular destinatários se os critérios mudaram
        $campaign = new EmailCampaign($validated);
        $recipients = $campaign->getTargetRecipients();
        $validated['total_recipients'] = $recipients->count();

        $emailCampaign->update($validated);

        // Atualizar destinatários se necessário
        if ($request->has('recalculate_recipients')) {
            $emailCampaign->recipients()->delete();
            
            foreach ($recipients as $customer) {
                $emailCampaign->recipients()->create([
                    'customer_id' => $customer->id,
                    'email' => $customer->email,
                    'status' => 'pending',
                ]);
            }
        }

        return redirect()->route('panel.email-marketing.show', $emailCampaign)
            ->with('success', 'Campanha atualizada com sucesso!');
    }

    /**
     * Enviar campanha
     */
    public function send(EmailCampaign $emailCampaign): RedirectResponse
    {
        // Verificar se a campanha pertence ao profissional
        if ($emailCampaign->professional_id !== $this->professionalId) {
            abort(403, 'Acesso negado');
        }

        if (!$emailCampaign->canBeSent()) {
            return redirect()->route('panel.email-marketing.show', $emailCampaign)
                ->with('error', 'Esta campanha não pode ser enviada.');
        }

        // Aqui você implementaria a lógica de envio real
        // Por enquanto, vamos apenas marcar como enviada
        $emailCampaign->update([
            'status' => 'sent',
            'sent_at' => now(),
            'sent_count' => $emailCampaign->total_recipients,
        ]);

        // Marcar todos os destinatários como enviados
        $emailCampaign->recipients()->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return redirect()->route('panel.email-marketing.show', $emailCampaign)
            ->with('success', 'Campanha enviada com sucesso!');
    }

    /**
     * Cancelar campanha
     */
    public function cancel(EmailCampaign $emailCampaign): RedirectResponse
    {
        // Verificar se a campanha pertence ao profissional
        if ($emailCampaign->professional_id !== $this->professionalId) {
            abort(403, 'Acesso negado');
        }

        if (!$emailCampaign->canBeCancelled()) {
            return redirect()->route('panel.email-marketing.show', $emailCampaign)
                ->with('error', 'Esta campanha não pode ser cancelada.');
        }

        $emailCampaign->update(['status' => 'cancelled']);

        return redirect()->route('panel.email-marketing.show', $emailCampaign)
            ->with('success', 'Campanha cancelada com sucesso!');
    }

    /**
     * Excluir campanha
     */
    public function destroy(EmailCampaign $emailCampaign): RedirectResponse
    {
        // Verificar se a campanha pertence ao profissional
        if ($emailCampaign->professional_id !== $this->professionalId) {
            abort(403, 'Acesso negado');
        }

        if (!$emailCampaign->canBeEdited()) {
            return redirect()->route('panel.email-marketing.index')
                ->with('error', 'Esta campanha não pode ser excluída.');
        }

        $emailCampaign->delete();

        return redirect()->route('panel.email-marketing.index')
            ->with('success', 'Campanha excluída com sucesso!');
    }

    /**
     * Gerenciar templates
     */
    public function templates(): View
    {
        $templates = EmailTemplate::forProfessional($this->professionalId)
            ->orderBy('name')
            ->get();

        return view('panel.email-marketing.templates', compact('templates'));
    }

    /**
     * Criar template
     */
    public function createTemplate(): View
    {
        return view('panel.email-marketing.create-template');
    }

    /**
     * Salvar template
     */
    public function storeTemplate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'text_content' => 'nullable|string',
            'type' => 'required|in:newsletter,promotion,reminder,follow_up,custom',
            'variables' => 'nullable|array',
            'is_default' => 'boolean',
        ]);

        $validated['professional_id'] = $this->professionalId;

        // Se for marcado como padrão, desmarcar outros templates do mesmo tipo
        if ($validated['is_default']) {
            EmailTemplate::forProfessional($this->professionalId)
                ->byType($validated['type'])
                ->update(['is_default' => false]);
        }

        EmailTemplate::create($validated);

        return redirect()->route('panel.email-marketing.templates')
            ->with('success', 'Template criado com sucesso!');
    }

    /**
     * Obter preview do template
     */
    public function previewTemplate(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string',
            'content' => 'required|string',
            'variables' => 'nullable|array',
        ]);

        $template = new EmailTemplate($validated);
        $processed = $template->processTemplate($validated['variables'] ?? []);

        return response()->json([
            'subject' => $processed['subject'],
            'content' => $processed['content'],
        ]);
    }

    /**
     * Obter destinatários baseados nos critérios
     */
    public function getRecipients(Request $request)
    {
        $validated = $request->validate([
            'target_criteria' => 'nullable|array',
        ]);

        $campaign = new EmailCampaign([
            'professional_id' => $this->professionalId,
            'target_criteria' => $validated['target_criteria'] ?? [],
        ]);

        $recipients = $campaign->getTargetRecipients();

        return response()->json([
            'count' => $recipients->count(),
            'recipients' => $recipients->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                ];
            }),
        ]);
    }
}