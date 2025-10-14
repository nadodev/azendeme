<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Waitlist;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;

class WaitlistController extends Controller
{
    protected $professionalId = 1;

    public function index()
    {
        $waitlist = Waitlist::where('professional_id', $this->professionalId)
            ->with(['customer', 'service'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'waiting' => Waitlist::where('professional_id', $this->professionalId)->waiting()->count(),
            'notified' => Waitlist::where('professional_id', $this->professionalId)->notified()->count(),
            'total' => Waitlist::where('professional_id', $this->professionalId)->count(),
        ];

        return view('panel.waitlist.index', compact('waitlist', 'stats'));
    }

    public function create()
    {
        $customers = Customer::where('professional_id', $this->professionalId)->orderBy('name')->get();
        $services = Service::where('professional_id', $this->professionalId)->where('active', true)->get();

        return view('panel.waitlist.create', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'preferred_date' => 'nullable|date',
            'preferred_time_start' => 'nullable',
            'preferred_time_end' => 'nullable',
            'notes' => 'nullable|string',
        ]);

        Waitlist::create(array_merge($validated, [
            'professional_id' => $this->professionalId,
            'status' => 'waiting',
        ]));

        return redirect()->route('panel.waitlist.index')
            ->with('success', 'Cliente adicionado à fila de espera!');
    }

    public function notify($id)
    {
        $waitlistItem = Waitlist::where('professional_id', $this->professionalId)->findOrFail($id);

        $waitlistItem->update([
            'status' => 'notified',
            'notified_at' => now(),
        ]);

        // Aqui você pode adicionar lógica de envio de e-mail/SMS
        // Mail::to($waitlistItem->customer->email)->send(new WaitlistNotification($waitlistItem));

        return redirect()->route('panel.waitlist.index')
            ->with('success', 'Cliente notificado com sucesso!');
    }

    public function convert($id)
    {
        $waitlistItem = Waitlist::where('professional_id', $this->professionalId)->findOrFail($id);

        $waitlistItem->update(['status' => 'converted']);

        return redirect()->route('panel.agenda.create', [
            'customer_id' => $waitlistItem->customer_id,
            'service_id' => $waitlistItem->service_id,
        ])->with('success', 'Redirecionado para criar agendamento!');
    }

    public function destroy($id)
    {
        $waitlistItem = Waitlist::where('professional_id', $this->professionalId)->findOrFail($id);
        $waitlistItem->delete();

        return redirect()->route('panel.waitlist.index')
            ->with('success', 'Removido da fila de espera!');
    }
}
