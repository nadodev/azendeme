<?php

namespace App\Http\Controllers;

use App\Models\BioPage;

class PublicBioController extends Controller
{
    public function show(string $slug)
    {
        $page = BioPage::with('links')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('public.bio', compact('page'));
    }
}


