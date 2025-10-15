<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use App\Models\Professional;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    protected $professionalId;
    public function __construct()
    {
        $this->professionalId = auth()->user()->id;
    }

    public function index()
    {
        $professional = Professional::findOrFail($this->professionalId);
        $socialLinks = SocialLink::where('professional_id', $this->professionalId)->get();
        
        // URL de agendamento direto
        $bookingUrl = url('/' . $professional->slug . '#agendar');
        
        // Gera dados para QR Code
        $qrCodeData = $bookingUrl;

        return view('panel.social.index', compact('professional', 'socialLinks', 'bookingUrl', 'qrCodeData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|in:instagram,facebook,tiktok,whatsapp,linkedin,youtube,twitter,website',
            'url' => 'required|url|max:500',
            'username' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['professional_id'] = $this->professionalId;
        $validated['is_active'] = $request->has('is_active');

        SocialLink::create($validated);

        return redirect()->route('panel.social.index')
            ->with('success', 'Link de rede social adicionado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $socialLink = SocialLink::where('professional_id', $this->professionalId)
            ->findOrFail($id);

        $validated = $request->validate([
            'platform' => 'required|in:instagram,facebook,tiktok,whatsapp,linkedin,youtube,twitter,website',
            'url' => 'required|url|max:500',
            'username' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $socialLink->update($validated);

        return redirect()->route('panel.social.index')
            ->with('success', 'Link atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $socialLink = SocialLink::where('professional_id', $this->professionalId)
            ->findOrFail($id);
        
        $socialLink->delete();

        return redirect()->route('panel.social.index')
            ->with('success', 'Link excluído com sucesso!');
    }

    public function updateBio(Request $request)
    {
        $validated = $request->validate([
            'bio' => 'nullable|string|max:500',
        ]);

        $professional = Professional::findOrFail($this->professionalId);
        $professional->update(['bio' => $validated['bio']]);

        return redirect()->route('panel.social.index')
            ->with('success', 'Bio atualizada com sucesso!');
    }
}

