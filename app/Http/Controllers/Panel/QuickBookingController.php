<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\QuickBookingLink;
use App\Models\Service;
use Illuminate\Http\Request;

class QuickBookingController extends Controller
{
    protected $professionalId;
    public function __construct()
    {
        $this->professionalId = auth()->user()->id;
    }

    public function index()
    {
        $links = QuickBookingLink::where('professional_id', $this->professionalId)
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'active' => QuickBookingLink::where('professional_id', $this->professionalId)->active()->count(),
            'total' => QuickBookingLink::where('professional_id', $this->professionalId)->count(),
            'total_uses' => QuickBookingLink::where('professional_id', $this->professionalId)->sum('uses_count'),
        ];

        return view('panel.quick-booking.index', compact('links', 'stats'));
    }

    public function create()
    {
        $services = Service::where('professional_id', $this->professionalId)
            ->where('active', true)
            ->get();

        return view('panel.quick-booking.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'service_id' => 'nullable|exists:services,id',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:today',
        ]);

        $link = QuickBookingLink::create(array_merge($validated, [
            'professional_id' => $this->professionalId,
            'active' => true,
        ]));

        return redirect()->route('panel.quick-booking.index')
            ->with('success', 'Link criado com sucesso!');
    }

    public function edit($id)
    {
        $link = QuickBookingLink::where('professional_id', $this->professionalId)->findOrFail($id);
        $services = Service::where('professional_id', $this->professionalId)
            ->where('active', true)
            ->get();

        return view('panel.quick-booking.edit', compact('link', 'services'));
    }

    public function update(Request $request, $id)
    {
        $link = QuickBookingLink::where('professional_id', $this->professionalId)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'service_id' => 'nullable|exists:services,id',
            'active' => 'boolean',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $link->update($validated);

        return redirect()->route('panel.quick-booking.index')
            ->with('success', 'Link atualizado com sucesso!');
    }

    public function toggleActive($id)
    {
        $link = QuickBookingLink::where('professional_id', $this->professionalId)->findOrFail($id);
        $link->update(['active' => !$link->active]);

        return redirect()->route('panel.quick-booking.index')
            ->with('success', 'Status do link atualizado!');
    }

    public function destroy($id)
    {
        $link = QuickBookingLink::where('professional_id', $this->professionalId)->findOrFail($id);
        $link->delete();

        return redirect()->route('panel.quick-booking.index')
            ->with('success', 'Link excluído com sucesso!');
    }
}
