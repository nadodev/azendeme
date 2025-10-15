<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\BioLink;
use App\Models\BioPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BioPageController extends Controller
{
    public function edit()
    {
        $professional = Auth::user()->professional;
        if (!$professional) abort(404);

        $page = BioPage::firstOrCreate(
            ['professional_id' => $professional->id],
            [
                'slug' => $professional->slug . '-bio',
                'title' => $professional->business_name ?? $professional->name,
                'theme_color' => '#333333',
                'background_color' => 'linear-gradient(180deg, #E0E7FF, #F0F4FF)',
                'button_color' => '#6366F1',
                'theme' => 'lavender-air',
                'enable_booking' => false,
            ]
        );

        $links = $page->links()->get();

        return view('panel.bio.edit', compact('page', 'links'));
    }

    public function update(Request $request)
    {
        $professional = Auth::user()->professional;
        if (!$professional) abort(404);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'required|string|max:255',
            'theme_color' => 'nullable|string',
            'background_color' => 'nullable|string',
            'button_color' => 'nullable|string',
            'theme' => 'nullable|string',
            'enable_booking' => 'nullable|boolean',
            'whatsapp_number' => 'nullable|string|max:30',
            'instagram_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|max:4096',
        ]);

        $page = BioPage::where('professional_id', $professional->id)->firstOrFail();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('bio', 'public');
            $data['avatar_path'] = 'storage/' . $path;
        }

        $theme = $data['theme'] ?? null;
        // Light & clean themes only
        $themes = [
            'minimal-white' => [
                'background' => '#F6F7F9',
                'button' => '#7C3AED',
                'icon' => '#333333',
            ],
            'clinic-soft' => [
                'background' => '#F3FAFF',
                'button' => '#2E90FF',
                'icon' => '#333333',
            ],
            'mint-fresh' => [
                'background' => '#F1FFF6',
                'button' => '#10B981',
                'icon' => '#333333',
            ],
            'beauty-blush' => [
                'background' => 'linear-gradient(180deg, #FFE3EC, #FFF7FA)',
                'button' => '#D946EF',
                'icon' => '#333333',
            ],
            'sand-cream' => [
                'background' => 'linear-gradient(180deg, #FFF5E6, #FFFFFF)',
                'button' => '#F59E0B',
                'icon' => '#333333',
            ],
            'lavender-air' => [
                'background' => 'linear-gradient(180deg, #E0E7FF, #F0F4FF)',
                'button' => '#6366F1',
                'icon' => '#333333',
            ],
            'sky-clean' => [
                'background' => 'linear-gradient(180deg, #E0F2FE, #F0F9FF)',
                'button' => '#0EA5E9',
                'icon' => '#333333',
            ],
            'pearl-gray' => [
                'background' => 'linear-gradient(180deg, #F8FAFC, #FFFFFF)',
                'button' => '#64748B',
                'icon' => '#333333',
            ],
        ];

        if ($theme && isset($themes[$theme])) {
            $data['background_color'] = $themes[$theme]['background'];
            $data['button_color'] = $themes[$theme]['button'];
            $data['theme_color'] = $themes[$theme]['icon'];
        }

        // normalize toggle
        $data['enable_booking'] = (bool) ($request->boolean('enable_booking'));

        $page->update($data);

        $links = $request->get('links', []);
        $page->links()->delete();
        $order = 0;
        foreach ($links as $link) {
            $label = trim($link['label'] ?? '');
            $url = trim($link['url'] ?? '');
            if ($label === '' || $url === '') continue;
            $type = $this->guessLinkType($url);
            $page->links()->create([
                'label' => $label,
                'url' => $url,
                'type' => $type,
                'sort_order' => $order++,
                'is_active' => true,
            ]);
        }

        return back()->with('success', 'Bio atualizada com sucesso!');
    }

    private function guessLinkType(string $url): string
    {
        $u = Str::lower($url);
        if (Str::contains($u, ['instagram.com'])) return 'instagram';
        if (Str::contains($u, ['wa.me', 'api.whatsapp.com', 'whatsapp.com'])) return 'whatsapp';
        if (Str::contains($u, ['youtube.com', 'youtu.be'])) return 'youtube';
        if (Str::contains($u, ['tiktok.com'])) return 'tiktok';
        if (preg_match('/^https?:\/\//', $u)) return 'website';
        return 'link';
    }
}


