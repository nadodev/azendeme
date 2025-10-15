<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPayment;
use App\Models\EventInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventPaymentController extends Controller
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

        $payments = EventPayment::whereHas('event', function($query) use ($professional) {
                $query->where('professional_id', $professional->id);
            })
            ->with(['event.customer', 'invoice'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('panel.events.payments.index', compact('payments'));
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

        $invoices = $event->invoices()->where('status', '!=', 'cancelada')->get();

        return view('panel.events.payments.create', compact('event', 'invoices'));
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
            'invoice_id' => 'required|exists:event_invoices,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:dinheiro,cartao_credito,cartao_debito,pix,transferencia,cheque,outro',
            'payment_reference' => 'nullable|string|max:255',
            'status' => 'nullable|in:pendente,confirmado,cancelado',
            'notes' => 'nullable|string',
        ]);


        // Gerar número do pagamento
        $paymentNumber = 'PAG-' . date('Y') . '-' . str_pad(EventPayment::count() + 1, 6, '0', STR_PAD_LEFT);


        $payment = EventPayment::create([
            'event_id' => $event->id,
            'invoice_id' => $request->invoice_id,
            'payment_number' => $paymentNumber,
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_reference' => $request->payment_reference,
            'status' => $request->status ?? 'pendente',
            'notes' => $request->notes,
        ]);



        // Se o pagamento está confirmado, verificar se a fatura foi totalmente paga
        if (($request->status ?? 'pendente') === 'confirmado' && $request->invoice_id) {
            $invoice = EventInvoice::find($request->invoice_id);
            if ($invoice) {
                // Recarregar a fatura para obter os dados atualizados
                $invoice->refresh();
                if ($invoice->is_fully_paid) {
                    $invoice->update(['status' => 'paga']);
                }
            }
        }

        return redirect()->route('panel.events.payments.show', $payment)
            ->with('success', 'Pagamento registrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventPayment $payment)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($payment->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $payment->load(['event.customer', 'invoice']);

        return view('panel.events.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventPayment $payment)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($payment->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $invoices = $payment->event->invoices()->where('status', '!=', 'cancelada')->get();

        return view('panel.events.payments.edit', compact('payment', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventPayment $payment)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($payment->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'invoice_id' => 'nullable|exists:event_invoices,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:dinheiro,cartao_credito,cartao_debito,pix,transferencia,cheque,outro',
            'payment_reference' => 'nullable|string|max:255',
            'status' => 'required|in:pendente,confirmado,cancelado',
            'notes' => 'nullable|string',
        ]);

        $payment->update($request->all());

        // Se o pagamento está confirmado, verificar se a fatura foi totalmente paga
        if ($request->status === 'confirmado' && $request->invoice_id) {
            $invoice = EventInvoice::find($request->invoice_id);
            if ($invoice && $invoice->is_fully_paid) {
                $invoice->update(['status' => 'paga']);
            }
        }

        return redirect()->route('panel.events.payments.show', $payment)
            ->with('success', 'Pagamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventPayment $payment)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($payment->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $payment->delete();

        return redirect()->route('panel.events.payments.index')
            ->with('success', 'Pagamento excluído com sucesso!');
    }

    /**
     * Confirm payment.
     */
    public function confirm(EventPayment $payment)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($payment->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $payment->update(['status' => 'confirmado']);

        // Verificar se a fatura foi totalmente paga
        if ($payment->invoice && $payment->invoice->is_fully_paid) {
            $payment->invoice->update(['status' => 'paga']);
        }

        return back()->with('success', 'Pagamento confirmado com sucesso!');
    }

    /**
     * Cancel payment.
     */
    public function cancel(EventPayment $payment)
    {
        $professional = Auth::user()->professional;
        if (!$professional) {
            abort(404, 'Profissional não encontrado. Entre em contato com o suporte.');
        }

        if ($payment->event->professional_id !== $professional->id) {
            abort(403, 'Acesso negado.');
        }

        $payment->update(['status' => 'cancelado']);

        return back()->with('success', 'Pagamento cancelado com sucesso!');
    }
}