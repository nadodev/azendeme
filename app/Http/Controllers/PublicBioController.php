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
        return view('public.bio', compact('page', 'services'));
    }
}


