<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventInvoice;
use App\Models\EventBudget;
use App\Models\EventServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventInvoiceController extends Controller
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

        $invoices = EventInvoice::whereHas('event', function($query) use ($professional) {
                $query->where('professional_id', $professional->id);
            })
            ->with(['event.customer', 'budget'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('panel.events.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $budget = $event->latestBudget();
        
        return view('panel.events.invoices.create', compact('event', 'budget'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'subtotal' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'payment_terms' => 'nullable|string',
        ]);

        // Calcular valores
        $subtotal = $request->subtotal;
        $discountPercentage = $request->discount_percentage ?? 0;
        $discountValue = ($subtotal * $discountPercentage) / 100;
        $taxPercentage = $request->tax_percentage ?? 0;
        $taxValue = (($subtotal - $discountValue) * $taxPercentage) / 100;
        $total = $subtotal - $discountValue + $taxValue;

        // Gerar número da fatura
        $invoiceNumber = 'FAT-' . date('Y') . '-' . str_pad(EventInvoice::count() + 1, 6, '0', STR_PAD_LEFT);

        $invoice = EventInvoice::create([
            'event_id' => $event->id,
            'budget_id' => $event->latestBudget()?->id,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'subtotal' => $subtotal,
            'discount_percentage' => $discountPercentage,
            'discount_value' => $discountValue,
            'tax_percentage' => $taxPercentage,
            'tax_value' => $taxValue,
            'total' => $total,
            'status' => 'rascunho',
            'notes' => $request->notes,
            'payment_terms' => $request->payment_terms,
        ]);

        return redirect()->route('panel.events.invoices.show', $invoice)
            ->with('success', 'Fatura criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventInvoice $invoice)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($invoice->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $invoice->load(['event.customer', 'budget', 'payments']);

        return view('panel.events.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventInvoice $invoice)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($invoice->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        return view('panel.events.invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventInvoice $invoice)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($invoice->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'subtotal' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:rascunho,enviada,paga,vencida,cancelada',
            'notes' => 'nullable|string',
            'payment_terms' => 'nullable|string',
        ]);

        // Calcular valores
        $subtotal = $request->subtotal;
        $discountPercentage = $request->discount_percentage ?? 0;
        $discountValue = ($subtotal * $discountPercentage) / 100;
        $taxPercentage = $request->tax_percentage ?? 0;
        $taxValue = (($subtotal - $discountValue) * $taxPercentage) / 100;
        $total = $subtotal - $discountValue + $taxValue;

        $invoice->update([
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'subtotal' => $subtotal,
            'discount_percentage' => $discountPercentage,
            'discount_value' => $discountValue,
            'tax_percentage' => $taxPercentage,
            'tax_value' => $taxValue,
            'total' => $total,
            'status' => $request->status,
            'notes' => $request->notes,
            'payment_terms' => $request->payment_terms,
        ]);

        return redirect()->route('panel.events.invoices.show', $invoice)
            ->with('success', 'Fatura atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventInvoice $invoice)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($invoice->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $invoice->delete();

        return redirect()->route('panel.events.invoices.index')
            ->with('success', 'Fatura excluída com sucesso!');
    }

    /**
     * Generate PDF for the invoice.
     */
    public function generatePdf(EventInvoice $invoice)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($invoice->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $invoice->load(['event.customer', 'budget', 'payments']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('panel.events.invoices.pdf', compact('invoice'));

        return $pdf->download("fatura-{$invoice->invoice_number}.pdf");
    }

    /**
     * Send invoice to customer.
     */
    public function sendToCustomer(EventInvoice $invoice)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($invoice->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $invoice->update(['status' => 'enviada']);

        return back()->with('success', 'Fatura enviada para o cliente!');
    }

    /**
     * Mark invoice as paid.
     */
    public function markAsPaid(EventInvoice $invoice)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($invoice->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $invoice->update(['status' => 'paga']);

        return back()->with('success', 'Fatura marcada como paga!');
    }

    /**
     * Create invoice from service order.
     */
    public function createFromServiceOrder(EventServiceOrder $serviceOrder)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($serviceOrder->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        if ($serviceOrder->status !== 'concluida') {
            return back()->with('error', 'Apenas Ordens de Serviço concluídas podem ser convertidas em fatura.');
        }

        // Verificar se já existe uma fatura para esta OS
        if ($serviceOrder->invoices()->exists()) {
            return back()->with('error', 'Já existe uma fatura para esta Ordem de Serviço.');
        }

        // Gerar número da fatura
        $invoiceNumber = 'FAT-' . date('Y') . '-' . str_pad(EventInvoice::count() + 1, 6, '0', STR_PAD_LEFT);

        $invoice = EventInvoice::create([
            'event_id' => $serviceOrder->event_id,
            'budget_id' => $serviceOrder->budget_id,
            'service_order_id' => $serviceOrder->id,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => now()->toDateString(),
            'due_date' => now()->addDays(30)->toDateString(),
            'subtotal' => $serviceOrder->total_value,
            'discount_percentage' => 0,
            'discount_value' => 0,
            'tax_percentage' => 0,
            'tax_value' => 0,
            'total' => $serviceOrder->total_value,
            'status' => 'rascunho',
            'notes' => 'Fatura gerada automaticamente a partir da Ordem de Serviço concluída.',
            'payment_terms' => 'Pagamento à vista ou conforme acordado.',
        ]);

        return redirect()->route('panel.events.invoices.show', $invoice)
            ->with('success', 'Fatura criada com sucesso a partir da Ordem de Serviço!');
    }
}