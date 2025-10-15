<?php

namespace App\Http\Controllers;

use App\Models\BioPage;
use App\Models\Service;

class PublicBioController extends Controller
{
    public function show(string $slug)
    {
        $page = BioPage::with('links', 'professional')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        $services = [];
        if ($page->professional) {
            $services = Service::where('professional_id', $page->professional->id)
                ->where('active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'duration', 'price']);
        }
        
        // Preparar dados SEO
        $seoData = $this->prepareSeoData($page);
        
        return view('public.bio', compact('page', 'services', 'seoData'));
    }
    
    private function prepareSeoData($page)
    {
        $professional = $page->professional;
        $businessName = $professional->business_name ?? $professional->name ?? $page->title;
        $description = $page->description ? strip_tags($page->description) : "Conheça {$businessName} e agende seus serviços online.";
        
        // Limitar descrição para SEO
        if (strlen($description) > 160) {
            $description = substr($description, 0, 157) . '...';
        }
        
        $url = route('public.bio', $page->slug);
        $image = $page->avatar_path ? asset($page->avatar_path) : asset('logo.png');
        
        return [
            'title' => "{$businessName} - {$page->title}",
            'description' => $description,
            'keywords' => $this->generateKeywords($page, $professional),
            'url' => $url,
            'image' => $image,
            'business_name' => $businessName,
            'professional_name' => $professional->name ?? $page->title,
            'phone' => $professional->phone ?? null,
            'email' => $professional->email ?? null,
            'address' => $professional->address ?? null,
            'services_count' => $page->professional ? $page->professional->services()->where('active', true)->count() : 0,
        ];
    }
    
    private function generateKeywords($page, $professional)
    {
        $keywords = [];
        
        // Adicionar nome do negócio e profissional
        if ($professional->business_name) {
            $keywords[] = $professional->business_name;
        }
        if ($professional->name) {
            $keywords[] = $professional->name;
        }
        
        // Adicionar tipo de negócio baseado no template
        $templateKeywords = [
            'clinic' => ['clínica', 'médico', 'saúde', 'consultório'],
            'salon' => ['salão', 'beleza', 'cabelo', 'estética'],
            'tattoo' => ['tatuagem', 'tatuador', 'estúdio', 'arte'],
            'barber' => ['barbearia', 'barbeiro', 'corte', 'barba']
        ];
        
        $template = $professional->template ?? 'clinic';
        if (isset($templateKeywords[$template])) {
            $keywords = array_merge($keywords, $templateKeywords[$template]);
        }
        
        // Adicionar palavras-chave genéricas
        $keywords = array_merge($keywords, [
            'agendamento online',
            'agenda digital',
            'marcação de horário',
            'serviços profissionais',
            'contato',
            'localização'
        ]);
        
        // Adicionar cidade se disponível
        if ($professional->city) {
            $keywords[] = $professional->city;
        }
        
        return implode(',', array_unique($keywords));
    }
}


