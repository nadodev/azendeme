<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventReceipt;
use App\Models\EventPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventReceiptController extends Controller
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

        $receipts = EventReceipt::whereHas('event', function($query) use ($professional) {
                $query->where('professional_id', $professional->id);
            })
            ->with(['event.customer', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('panel.events.receipts.index', compact('receipts'));
    }

    /**
     * Show the form for selecting an event to create a receipt.
     */
    public function selectEvent()
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        $events = Event::where('professional_id', $professional->id)
            ->with('customer')
            ->orderBy('event_date', 'desc')
            ->paginate(15);

        return view('panel.events.receipts.select-event', compact('events'));
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

        $payments = $event->payments()->where('status', 'confirmado')->get();

        return view('panel.events.receipts.create', compact('event', 'payments'));
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
            'payment_id' => 'nullable|exists:event_payments,id',
            'receipt_date' => 'required|date',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:dinheiro,cartao_credito,cartao_debito,pix,transferencia,cheque,outro',
            'payment_reference' => 'nullable|string|max:255',
            'payer_name' => 'required|string|max:255',
            'payer_document' => 'nullable|string|max:20',
            'payer_address' => 'nullable|string',
            'services_description' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Gerar número do recibo
        $receiptNumber = 'REC-' . date('Y') . '-' . str_pad(EventReceipt::count() + 1, 6, '0', STR_PAD_LEFT);

        $receipt = EventReceipt::create([
            'event_id' => $event->id,
            'payment_id' => $request->payment_id,
            'receipt_number' => $receiptNumber,
            'receipt_date' => $request->receipt_date,
            'description' => $request->description,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_reference' => $request->payment_reference,
            'payer_name' => $request->payer_name,
            'payer_document' => $request->payer_document,
            'payer_address' => $request->payer_address,
            'services_description' => $request->services_description,
            'status' => 'rascunho',
            'notes' => $request->notes,
        ]);

        return redirect()->route('panel.events.receipts.show', $receipt)
            ->with('success', 'Recibo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventReceipt $receipt)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($receipt->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $receipt->load(['event.customer', 'payment']);

        return view('panel.events.receipts.show', compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventReceipt $receipt)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($receipt->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $payments = $receipt->event->payments()->where('status', 'confirmado')->get();

        return view('panel.events.receipts.edit', compact('receipt', 'payments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventReceipt $receipt)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($receipt->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'payment_id' => 'nullable|exists:event_payments,id',
            'receipt_date' => 'required|date',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:dinheiro,cartao_credito,cartao_debito,pix,transferencia,cheque,outro',
            'payment_reference' => 'nullable|string|max:255',
            'payer_name' => 'required|string|max:255',
            'payer_document' => 'nullable|string|max:20',
            'payer_address' => 'nullable|string',
            'services_description' => 'required|string',
            'status' => 'required|in:rascunho,emitido,cancelado',
            'notes' => 'nullable|string',
        ]);

        $receipt->update($request->all());

        return redirect()->route('panel.events.receipts.show', $receipt)
            ->with('success', 'Recibo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventReceipt $receipt)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($receipt->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $receipt->delete();

        return redirect()->route('panel.events.receipts.index')
            ->with('success', 'Recibo excluído com sucesso!');
    }

    /**
     * Generate PDF for receipt.
     */
    public function pdf(EventReceipt $receipt)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($receipt->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $receipt->load(['event.customer', 'payment']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('panel.events.receipts.pdf', compact('receipt'));

        return $pdf->download("recibo-{$receipt->receipt_number}.pdf");
    }

    /**
     * Issue receipt.
     */
    public function issue(EventReceipt $receipt)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($receipt->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $receipt->update(['status' => 'emitido']);

        return back()->with('success', 'Recibo emitido com sucesso!');
    }

    /**
     * Mark receipt as paid.
     */
    public function markAsPaid(EventReceipt $receipt)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($receipt->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $receipt->update(['status' => 'pago']);

        return back()->with('success', 'Recibo marcado como pago com sucesso!');
    }
}