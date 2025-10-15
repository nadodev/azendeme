<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>{{ $seoData['title'] }}</title>
    <meta name="description" content="{{ $seoData['description'] }}">
    <meta name="keywords" content="{{ $seoData['keywords'] }}">
    <meta name="author" content="{{ $seoData['professional_name'] }}">
    <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
    <meta name="googlebot" content="index,follow">
    <meta name="bingbot" content="index,follow">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ $seoData['url'] }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="profile">
    <meta property="og:url" content="{{ $seoData['url'] }}">
    <meta property="og:title" content="{{ $seoData['title'] }}">
    <meta property="og:description" content="{{ $seoData['description'] }}">
    <meta property="og:image" content="{{ $seoData['image'] }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $seoData['business_name'] }}">
    <meta property="og:site_name" content="aZendeMe">
    <meta property="og:locale" content="pt_BR">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $seoData['url'] }}">
    <meta name="twitter:title" content="{{ $seoData['title'] }}">
    <meta name="twitter:description" content="{{ $seoData['description'] }}">
    <meta name="twitter:image" content="{{ $seoData['image'] }}">
    <meta name="twitter:image:alt" content="{{ $seoData['business_name'] }}">
    <meta name="twitter:creator" content="@azendeme">
    <meta name="twitter:site" content="@azendeme">
    
    <!-- Additional SEO Meta Tags -->
    <meta name="theme-color" content="{{ $page->theme_color ?? '#8B5CF6' }}">
    <meta name="msapplication-TileColor" content="{{ $page->theme_color ?? '#8B5CF6' }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="{{ $seoData['business_name'] }}">
    
    <!-- Geo Tags -->
    <meta name="geo.region" content="BR">
    <meta name="geo.country" content="Brasil">
    @if($seoData['address'])
        <meta name="geo.placename" content="{{ $seoData['address'] }}">
    @endif
    
    <!-- Language -->
    <meta name="language" content="pt-BR">
    <meta name="content-language" content="pt-BR">
    
    <!-- Cache Control -->
    <meta http-equiv="Cache-Control" content="public, max-age=31536000">
    
    <!-- Security -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    
    <!-- Performance -->
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    
    <!-- Favicon -->
    @include('partials.favicon')
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Structured Data -->
    @php
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $seoData['business_name'],
            'description' => $seoData['description'],
            'url' => $seoData['url'],
            'image' => $seoData['image'],
            'telephone' => $seoData['phone'],
            'email' => $seoData['email'],
            'address' => $seoData['address'] ? [
                '@type' => 'PostalAddress',
                'streetAddress' => $seoData['address']
            ] : null,
            'openingHours' => 'Mo-Su 08:00-18:00',
            'priceRange' => '$$',
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.8',
                'ratingCount' => '25',
                'bestRating' => '5',
                'worstRating' => '1'
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Serviços',
                'itemListElement' => $services->map(function($service) {
                    return [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => $service->name,
                            'description' => $service->name,
                            'provider' => [
                                '@type' => 'LocalBusiness',
                                'name' => $seoData['business_name']
                            ]
                        ],
                        'price' => $service->price,
                        'priceCurrency' => 'BRL',
                        'availability' => 'https://schema.org/InStock'
                    ];
                })->toArray()
            ],
            'sameAs' => array_filter([
                $page->instagram_url,
                $page->facebook_url,
                $page->twitter_url,
                $page->youtube_url,
                $page->tiktok_url,
                $page->linkedin_url
            ])
        ];
        
        // Remover campos nulos
        $structuredData = array_filter($structuredData, function($value) {
            return $value !== null;
        });
    @endphp
    
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    <style>
        :root {
            --bg: {{ $page->background_color ?? 'linear-gradient(180deg, #E0E7FF 0%, #F0F4FF 100%)' }};
            --btn: {{ $page->button_color ?? '#6366F1' }};
            --text: {{ $page->theme_color ?? '#333333' }};
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        .container {
            max-width: 680px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 32px;
            padding: 48px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            position: relative;
        }
        .share-btn { position:absolute; top:24px; right:24px; width:48px; height:48px; background:white; border:none; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(0,0,0,.08); transition:all .2s; }
        .share-btn:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(0,0,0,.12); }
        .header { text-align:center; margin-bottom:32px; }
        .avatar { width:120px; height:120px; border-radius:50%; object-fit:cover; margin:0 auto 20px; display:block; border:4px solid white; box-shadow:0 8px 24px rgba(0,0,0,.12); }
        .name { font-size:24px; font-weight:700; color:var(--text); margin-bottom:8px; }
        .bio { font-size:15px; color:#666; line-height:1.5; margin-bottom:20px; }
        .social-icons { display:flex; gap:12px; justify-content:center; margin-bottom:32px; }
        .social-icon { width:44px; height:44px; background:var(--btn); border-radius:50%; display:flex; align-items:center; justify-content:center; text-decoration:none; transition:all .2s; }
        .social-icon:hover { transform:translateY(-3px); box-shadow:0 6px 16px rgba(0,0,0,.15); }
        .social-icon svg { width:20px; height:20px; fill:white; }
        .links { display:flex; flex-direction:column; gap:16px; margin-bottom:32px; }
        .link-item { background:#ffffff; border-radius:16px; padding:18px 16px 18px 18px; text-decoration:none; color:var(--text); font-weight:600; font-size:15px; display:flex; align-items:center; gap:16px; transition:all .25s ease; border:1.5px solid rgba(0,0,0,.06); box-shadow:0 6px 14px rgba(0,0,0,.06); }
        .link-item:hover { transform:translateY(-2px); box-shadow:0 10px 22px rgba(0,0,0,.10); border-color: color-mix(in srgb, var(--btn) 45%, #ffffff); }
        .link-icon { width:32px; height:32px; background:var(--btn); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .link-icon svg { width:18px; height:18px; fill:white; }
        .link-text { flex:1; color:var(--text); text-decoration:none; line-height:1.2; }
        .link-share { width:36px; height:36px; background:rgba(99,102,241,.10); border-radius:8px; border:1px solid rgba(0,0,0,.06); cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all .2s; }
        .link-share:hover { background:rgba(99,102,241,.18); }
        .link-share svg { width:16px; height:16px; fill:var(--text); }
        .footer { display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; }
        .join-btn { background:var(--btn); color:white; padding:14px 28px; border-radius:12px; text-decoration:none; font-weight:600; font-size:15px; display:inline-block; transition:all .2s; }
        .join-btn:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(0,0,0,.15); }
        .qr-code { background:white; padding:12px; border-radius:16px; box-shadow:0 4px 12px rgba(0,0,0,.08); }
        .qr-code img { display:block; width:120px; height:120px; }

        /* Booking button + Drawer */
        .book-btn { margin-top: 8px; background: var(--btn); color:#fff; padding: 12px 18px; border-radius: 10px; font-weight: 600; border: 0; cursor:pointer; }
        .drawer { position: fixed; right: -420px; top: 0; width: 420px; max-width: 95vw; height: 100vh; background: #fff; box-shadow: -12px 0 30px rgba(0,0,0,.18); transition: right .3s ease; z-index: 60; display: flex; flex-direction: column; }
        .drawer.open { right: 0; }
        .drawer-header { padding: 16px 18px; border-bottom: 1px solid #eee; display: flex; align-items: center; justify-content: space-between; }
        .drawer-title { font-weight: 700; color: #111827; }
        .drawer-body { padding: 16px 18px 96px; overflow-y: auto; }
        .drawer-footer { position: absolute; left: 0; right: 0; bottom: 0; padding: 12px 16px; background: linear-gradient(180deg, rgba(255,255,255,0), rgba(255,255,255,.85) 18%, #fff 60%); border-top: 1px solid #e5e7eb; display: flex; gap: 10px; }
        .drawerActionBtn { flex: 1; background: var(--btn); color: #fff; border: 0; padding: 14px 16px; border-radius: 12px; font-weight: 700; }
        .drawerActionBtn[disabled] { opacity: .6; filter: grayscale(.2); }
        .service { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; border: 1px solid #eee; border-radius: 10px; margin-bottom: 10px; }
        .service .action { background:transparent; border:1px solid #e5e7eb; padding:8px 10px; border-radius:8px; cursor:pointer; }
        .service.selected { border-color: var(--btn); background: #f5f3ff; }
        .summary { margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee; color:#374151; }
        .calendar { margin-top: 14px; display:grid; grid-template-columns: repeat(7, 1fr); gap:6px; }
        .cal-header { display:flex; align-items:center; justify-content:space-between; gap:8px; margin-top:12px; }
        .cal-nav { display:flex; gap:8px; }
        .cal-btn { background:#f3f4f6; border:1px solid #e5e7eb; padding:6px 10px; border-radius:8px; cursor:pointer; }
        .day { padding:10px; text-align:center; border-radius:8px; background:#f3f4f6; cursor:not-allowed; color:#9ca3af; }
        .day.available { background:#ecfeff; color:#0369a1; cursor:pointer; }
        .day.available:hover { background:#cffafe; }
        .day.selected { background: var(--btn) !important; color: #fff !important; box-shadow: 0 0 0 2px rgba(99,102,241,.15) inset; }
        .slot-list { margin-top:12px; display:flex; gap:8px; flex-wrap:wrap; }
        .slot { padding:8px 10px; border:1px solid #e5e7eb; border-radius:8px; cursor:pointer; }
        .slot.active { background: var(--btn); color:#fff; border-color: var(--btn); }
        .book-submit { display:none; }
        .backdrop { position: fixed; inset:0; background: rgba(0,0,0,.3); opacity:0; pointer-events:none; transition: opacity .3s ease; z-index:50; }
        .backdrop.show { opacity:1; pointer-events:auto; }
        .toast { position: fixed; left: 50%; bottom: 24px; transform: translateX(-50%); background: #111827; color:#fff; padding:10px 14px; border-radius:10px; font-size:14px; opacity:0; pointer-events:none; transition: opacity .25s ease; z-index:70; }
        .toast.show { opacity:1; }

        @media (max-width: 640px) { .drawer{ right:-100%; width:100%; max-width:100vw; border-radius:0 } .container{ padding:32px 24px; border-radius:24px } .name{ font-size:20px } .footer{ flex-direction:column; text-align:center } }
    </style>
</head>
<body>
    @php $publicUrl = route('public.bio', $page->slug); @endphp
    
    <div class="container">
        <button class="share-btn" onclick="sharePage('{{ addslashes($publicUrl) }}')" aria-label="Compartilhar página">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7a3.27 3.27 0 0 0 0-1.39l7.02-4.11A2.99 2.99 0 1 0 14 5a3 3 0 0 0 .05.53L7.02 9.64a3 3 0 1 0 0 4.72l7.03 4.12c-.03.17-.05.35-.05.53a3 3 0 1 0 3-3z" fill="{{ $page->theme_color ?? '#333' }}"/></svg>
        </button>

        <div class="header">
            @if($page->avatar_path)
                <img class="avatar" src="{{ asset($page->avatar_path) }}" alt="{{ $page->title }}">
            @endif
            <h1 class="name">{{ $page->title }}</h1>
            @if($page->description)
                <p class="bio">{!! nl2br(e($page->description)) !!}</p>
            @endif
            @if($page->enable_booking)
                <button class="book-btn" onclick="openDrawer()">Agendar</button>
            @endif
        </div>

        @if($page->instagram_url || $page->facebook_url || $page->twitter_url || $page->youtube_url || $page->tiktok_url || $page->linkedin_url || $page->whatsapp_number)
        <div class="social-icons">
            <!-- existing social icons -->
            @if($page->instagram_url)
                <a href="{{ $page->instagram_url }}" target="_blank" rel="noopener" class="social-icon"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
            @endif
            @if($page->whatsapp_number)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $page->whatsapp_number) }}" target="_blank" rel="noopener" class="social-icon"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.86 1.04-.16.18-.32.2-.59.07-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
            @endif
            @if($page->facebook_url)
                <a href="{{ $page->facebook_url }}" target="_blank" rel="noopener" class="social-icon"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
            @endif
            @if($page->youtube_url)
                <a href="{{ $page->youtube_url }}" target="_blank" rel="noopener" class="social-icon"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c2.1.6 9.4.6 9.4.6s7.3 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.2 31.2 0 0 0 24 12a31.2 31.2 0 0 0-.5-5.8zM9.5 15.5v-7l6 3.5-6 3.5z"/></svg></a>
            @endif
            @if($page->tiktok_url)
                <a href="{{ $page->tiktok_url }}" target="_blank" rel="noopener" class="social-icon"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg></a>
            @endif
            @if($page->twitter_url)
                <a href="{{ $page->twitter_url }}" target="_blank" rel="noopener" class="social-icon"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
            @endif
            @if($page->linkedin_url)
                <a href="{{ $page->linkedin_url }}" target="_blank" rel="noopener" class="social-icon"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
            @endif
        </div>
        @endif

        @if($page->links->count() > 0)
        <div class="links">
            @php
                function getLinkIcon($type){
                    switch($type){
                        case 'instagram': return '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm5 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6.75-2.9a1.25 1.25 0 1 0 0 2.5 1.25 1.25 0 0 0 0-2.5z"/></svg>';
                        case 'whatsapp': return '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M19.11 17.59c-.27-.13-1.59-.78-1.84-.87-.25-.09-.43-.13-.61.13-.18.27-.7.87-.86 1.04-.16.18-.32.2-.59.07-.27-.13-1.13-.41-2.15-1.3-.79-.7-1.32-1.56-1.48-1.82-.16-.27-.02-.42.11-.55.11-.11.25-.29.37-.43.13-.14.16-.24.25-.41.09-.18.05-.32-.02-.45-.07-.13-.61-1.47-.83-2.02-.22-.53-.44-.46-.61-.47h-.52c-.18 0-.45.07-.68.34-.23.27-.89.86-.89 2.11 0 1.25.92 2.46 1.05 2.63.13.18 1.82 2.78 4.41 3.9.62.27 1.11.43 1.49.55.63.2 1.21.17 1.67.1.51-.08 1.59-.65 1.82-1.28.23-.63.23-1.16.16-1.28-.07-.11-.25-.18-.52-.3z"/></svg>';
                        case 'youtube': return '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.3 3.5 12 3.5 12 3.5s-7.3 0-9.4.6A3 3 0 0 0 .5 6.2 31.2 31.2 0 0 0 0 12a31.2 31.2 0 0 0 .6 5.8 3 3 0 0 0 2.1 2.1c2.1.6 9.4.6 9.4.6s7.3 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.2 31.2 0 0 0 24 12a31.2 31.2 0 0 0-.5-5.8zM9.5 15.5v-7l6 3.5-6 3.5z"/></svg>';
                        case 'tiktok': return '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M19.3 4h3c.5 2.2 2 3.8 3.8 4.2v3.1c-1.6-.1-3.1-.6-4.5-1.4v7.8c0 4.3-3.5 7.8-7.8 7.8S6 22 6 17.7 9.5 9.9 13.8 9.9h.7v3.4h-.7a4.4 4.4 0 1 0 0 8.8 4.4 4.4 0 0 0 4.4-4.4V4z"/></svg>';
                        case 'website': return '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2zm0 2a8 8 0 0 1 7.5 5H4.5A8 8 0 0 1 12 4zm0 16a8 8 0 0 1-7.5-5h15A8 8 0 0 1 12 20zm-7.9-7a8 8 0 0 1 0-2h15.8a8 8 0 0 1 0 2H4.1z"/></svg>';
                        default: return '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3.9 12a4.1 4.1 0 0 1 4.1-4.1h4V10h-4a2 2 0 1 0 0 4h3.5v2H8a4.1 4.1 0 0 1-4.1-4zm7.5 0a4.1 4.1 0 0 1 4.1-4.1H16a4.1 4.1 0 1 1 0 8h-4v-2h4a2 2 0 1 0 0-4h-4z"/></svg>';
                    }
                }
            @endphp
            @foreach($page->links as $link)
                @if($link->is_active)
                    <div class="link-item">
                        <div class="link-icon">{!! getLinkIcon($link->type ?? 'link') !!}</div>
                        <a href="{{ $link->url }}" target="_blank" rel="noopener" class="link-text">{{ $link->label }}</a>
                        <button class="link-share" title="Compartilhar" onclick="shareLink(event, '{{ addslashes($link->label) }}', '{{ addslashes($link->url) }}')"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7a3.27 3.27 0 0 0 0-1.39l7.02-4.11A2.99 2.99 0 1 0 14 5a3 3 0 0 0 .05.53L7.02 9.64a3 3 0 1 0 0 4.72l7.03 4.12c-.03.17-.05.35-.05.53a3 3 0 1 0 3-3z"/></svg></button>
                    </div>
                @endif
            @endforeach
        </div>
        @endif

        <div class="footer">
            <a class="join-btn" href="{{ url('/registrar') }}" target="_blank" rel="noopener">Junte-se a  {{ $page->title }} no aZendeMe</a>
            <div class="qr-code"><img alt="QR Code" src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data={{ urlencode($publicUrl) }}" /></div>
        </div>
    </div>

    @if($page->enable_booking)
    <div id="drawerBackdrop" class="backdrop" onclick="closeDrawer()"></div>
    <div id="drawer" class="drawer" aria-hidden="true">
        <div class="drawer-header">
            <div class="drawer-title">Agendar</div>
            <button onclick="closeDrawer()" style="background:transparent;border:0;font-size:20px;line-height:1;cursor:pointer">×</button>
        </div>
        <div class="drawer-body">
            <div id="servicesContainer"></div>
            <div class="summary" id="summaryContainer" style="display:none"></div>
            <div id="calendarContainer"></div>
            <div id="slotsContainer" class="slot-list"></div>
            <form id="bookingForm" onsubmit="submitBooking(event)" style="display:none">
                <input type="hidden" id="bk_services" value="">
                <input type="text" id="bk_name" placeholder="Seu nome" required style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:10px;margin-top:10px">
                <input type="email" id="bk_email" placeholder="Seu e-mail" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:10px;margin-top:10px">
                <input type="tel" id="bk_phone" placeholder="Seu telefone" required style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:10px;margin-top:10px">
                <button class="book-submit" type="submit">Confirmar agendamento</button>
            </form>
        </div>
        <div class="drawer-footer">
            <button id="drawerAction" class="drawerActionBtn" disabled onclick="triggerSubmit()">Confirmar agendamento</button>
        </div>
    </div>
    <div id="toast" class="toast" role="status" aria-live="polite"></div>
    @endif

    <script>
    async function sharePage(url){ const data = { title: document.title, text: document.title, url }; if (navigator.share){ try{ await navigator.share(data); }catch(_){} } else { try{ await navigator.clipboard.writeText(url); alert('Link copiado!'); }catch(_){ window.prompt('Copie o link:', url); } } }
    async function shareLink(ev, title, url){ ev.preventDefault(); ev.stopPropagation(); const data = { title, text: title, url }; if (navigator.share){ try{ await navigator.share(data); }catch(_){} } else { try{ await navigator.clipboard.writeText(url); alert('Link copiado!'); }catch(_){ window.prompt('Copie o link:', url); } } }

    function openDrawer(){ document.getElementById('drawer').classList.add('open'); document.getElementById('drawerBackdrop').classList.add('show'); loadBookingData(); fetchAvailabilityAndRender(); }
    function closeDrawer(){ resetBooking(); document.getElementById('drawer').classList.remove('open'); document.getElementById('drawerBackdrop').classList.remove('show'); }

    // Demo loader: replace with real endpoints later
    function loadBookingData(){
        const svcs = @json($services ?? []);
        const servicesHtml = (svcs.length ? svcs : []).map(s => {
            const price = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(parseFloat(s.price));
            return `<div class="service" data-id="${s.id}" data-duration="${s.duration}" data-price="${s.price}">
                        <div><strong>${s.name}</strong><div style="font-size:12px;color:#6b7280">${s.duration} min • ${price}</div></div>
                        <button class="action" onclick="toggleService(${s.id})">Adicionar</button>
                    </div>`;
        }).join('');
        const emptyHtml = `<div style="color:#6b7280;font-size:14px">Nenhum serviço disponível no momento.</div>`;
        document.getElementById('servicesContainer').innerHTML = `<h4 style="margin-bottom:8px">Serviços</h4>${servicesHtml || emptyHtml}`;
        renderSummary();
        renderCalendar(new Date());
    }

    let selectedServiceIds = []; let selectedServiceTotal = 0;
    let calendarBase = new Date();
    let availableDaysCache = { }; // key: YYYY-MM -> Set(days 'YYYY-MM-DD')

    function monthKey(d){ return d.getFullYear()+"-"+String(d.getMonth()+1).padStart(2,'0'); }
    function formatYM(d){ return d.toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' }); }

    function changeMonth(delta){ calendarBase.setMonth(calendarBase.getMonth()+delta); fetchAvailabilityAndRender(); }

    function fetchAvailabilityAndRender(){
        const slugUrl = "{{ $page->professional ? route('public.availability', $page->professional->slug) : '' }}";
        const y = calendarBase.getFullYear(); const m = calendarBase.getMonth()+1;
        const key = monthKey(calendarBase);
        const finish = () => renderCalendar(calendarBase);
        if (availableDaysCache[key]){ finish(); return; }
        if (!slugUrl){ availableDaysCache[key] = new Set(); finish(); return; }
        fetch(`${slugUrl}?month=${m}&year=${y}`, { headers: { 'Accept':'application/json' }})
            .then(r=>r.json())
            .then(data=>{
                const days = Array.isArray(data.available_days) ? data.available_days : [];
                availableDaysCache[key] = new Set(days);
            })
            .catch(()=>{ availableDaysCache[key] = new Set(); })
            .finally(finish);
    }

    function toggleService(id){
        const card = document.querySelector(`.service[data-id='${id}']`);
        if (!card) return;
        const price = parseFloat(card.getAttribute('data-price')) || 0;
        if (selectedServiceIds.includes(id)){
            selectedServiceIds = selectedServiceIds.filter(x => x !== id);
            selectedServiceTotal -= price;
            card.classList.remove('selected');
            card.querySelector('.action').textContent = 'Adicionar';
        } else {
            selectedServiceIds.push(id);
            selectedServiceTotal += price;
            card.classList.add('selected');
            card.querySelector('.action').textContent = 'Remover';
        }
        renderSummary();
        document.getElementById('bookingForm').style.display = selectedServiceIds.length ? 'block' : 'none';
        updateActionButtonState();
    }

    function renderSummary(){
        const el = document.getElementById('summaryContainer');
        if (!selectedServiceIds.length){ el.style.display = 'none'; el.innerHTML = ''; document.getElementById('bk_services').value=''; return; }
        const total = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(selectedServiceTotal);
        el.style.display = 'block';
        el.innerHTML = `<div><strong>Selecionados:</strong> ${selectedServiceIds.length} • <strong>Total:</strong> ${total}</div>`;
        document.getElementById('bk_services').value = selectedServiceIds.join(',');
    }

    let selectedDate = null; let selectedSlot = null;
    function selectService(id){ selectedServiceId = id; document.getElementById('bookingForm').style.display='block'; }

    function renderCalendar(base){
        const cont = document.getElementById('calendarContainer');
        const year = base.getFullYear(); const month = base.getMonth();
        const first = new Date(year, month, 1); const last = new Date(year, month+1, 0);
        const key = monthKey(base);
        const avail = availableDaysCache[key] || new Set();
        const today = new Date(); today.setHours(0,0,0,0);
        let html = `<div class='cal-header'><div style='font-weight:700;color:#111827'>${formatYM(base)}</div><div class='cal-nav'><button class='cal-btn' onclick='changeMonth(-1)' aria-label='Mês anterior'>&lt;</button><button class='cal-btn' onclick='changeMonth(1)' aria-label='Próximo mês'>&gt;</button></div></div>`;
        html += `<div class='calendar' role='grid'>`;
        const startWeekday = (first.getDay()+6)%7; for(let i=0;i<startWeekday;i++){ html += `<div></div>`; }
        for(let d=1; d<=last.getDate(); d++){
            const dt = new Date(year, month, d);
            const dateStr = dt.toISOString().slice(0,10);
            const isPast = dt < today;
            const isAvailable = avail.has(dateStr) && !isPast;
            const attrs = isAvailable ? `class='day available' role='gridcell' aria-selected='false' onclick='selectDate(event, ${year},${month},${d})'` : `class='day' role='gridcell' aria-disabled='true'`;
            html += `<div ${attrs}>${d}</div>`;
        }
        html += `</div>`; cont.innerHTML = html;
    }

    function selectDate(ev,y,m,d){ selectedDate = new Date(y,m,d);
        if (!selectedServiceIds.length){ showToast('Selecione um serviço antes de escolher a data.'); return; }
        document.querySelectorAll('.calendar .day.available').forEach(el=>{ el.classList.remove('selected'); el.setAttribute('aria-selected','false'); });
        const el = ev.currentTarget || ev.target; if (el){ el.classList.add('selected'); el.setAttribute('aria-selected','true'); }
        // Busca horários disponíveis reais usando o primeiro serviço selecionado
        const firstServiceId = selectedServiceIds[0];
        const slugUrl = "{{ $page->professional ? route('public.slots', $page->professional->slug) : '' }}";
        const dateStr = selectedDate.toISOString().slice(0,10);
        if (slugUrl && firstServiceId){
            const duration = (window.selectedServiceIds || []).length ? Array.from(document.querySelectorAll('.service.selected')).map(el=>parseInt(el.getAttribute('data-duration')||'0')||0).reduce((a,b)=>a+b,0) : 0;
            const qs = `date=${encodeURIComponent(dateStr)}&service_id=${firstServiceId}${duration?`&duration=${duration}`:''}`;
            fetch(`${slugUrl}?${qs}`, { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(slots => { renderSlots(Array.isArray(slots) ? slots : []); })
                .catch(() => { renderSlots([]); });
        } else {
            renderSlots([]);
        }
        updateActionButtonState();
    }

    function renderSlots(slots){
        const cont = document.getElementById('slotsContainer');
        if (!slots.length){ cont.innerHTML = `<div style='color:#6b7280'>Sem horários disponíveis nesta data.</div>`; selectedSlot=null; updateActionButtonState(); return; }
        cont.innerHTML = `<h4>Horários</h4>` + slots.map(t=>`<span class='slot' onclick=\"selectSlot('${t}')\">${t}</span>`).join('');
    }
    function selectSlot(t){ selectedSlot=t; document.querySelectorAll('.slot').forEach(s=>s.classList.remove('active')); [...document.querySelectorAll('.slot')].find(s=>s.textContent===t).classList.add('active'); updateActionButtonState(); }

    function updateActionButtonState(){
        const btn = document.getElementById('drawerAction');
        if (!btn) return;
        const ready = selectedServiceIds.length && selectedDate && selectedSlot;
        btn.disabled = !ready;
    }

    function triggerSubmit(){
        if (document.getElementById('drawerAction').disabled) return;
        const form = document.getElementById('bookingForm');
        if (form) submitBooking(new Event('submit', { cancelable: true }));
    }

    function submitBooking(ev){ ev.preventDefault(); if(!selectedServiceIds.length || !selectedDate || !selectedSlot){ alert('Selecione serviço(s), data e horário'); return; }
        const url = "{{ $page->professional ? route('public.book', $page->professional->slug) : '' }}";
        if (!url){ alert('Profissional não encontrado.'); return; }
        const payload = {
            service_ids: selectedServiceIds.map(Number),
            date: selectedDate.toISOString().slice(0,10),
            time: selectedSlot,
            name: document.getElementById('bk_name').value,
            phone: document.getElementById('bk_phone').value,
            email: document.getElementById('bk_email').value || null
        };
        const btn = ev.submitter || document.querySelector('.book-submit');
        if (btn) { btn.disabled = true; btn.textContent = 'Enviando...'; }
        fetch(url, { method: 'POST', credentials: 'same-origin', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'X-Requested-With': 'XMLHttpRequest' }, body: JSON.stringify(payload) })
            .then(async (r) => { const ct = r.headers.get('content-type')||''; const data = ct.includes('application/json') ? await r.json() : { success:false, message:'Erro inesperado ('+r.status+').' }; return { ok:r.ok, status:r.status, data }; })
            .then(({ok,status,data}) => {
                if (ok && data && data.success){
                    alert('Agendamento realizado com sucesso!');
                    resetBooking();
                    closeDrawer();
                } else {
                    if (status === 409){ alert('Este horário acabou de ser reservado. Tente outro horário.'); return; }
                    const msg = (data && (data.message || (data.errors && Object.values(data.errors).flat().join('\n')))) || 'Não foi possível realizar o agendamento.';
                    alert(msg);
                }
            })
            .catch(() => alert('Erro de rede ao enviar o agendamento.'))
            .finally(() => { if (btn) { btn.disabled = false; btn.textContent = 'Confirmar agendamento'; } });
    }

    function resetBooking(){
        // clear selected services
        selectedServiceIds = []; selectedServiceTotal = 0;
        document.querySelectorAll('.service').forEach(card=>{ card.classList.remove('selected'); const b=card.querySelector('.action'); if(b) b.textContent='Adicionar'; });
        renderSummary();
        // clear date + slots
        selectedDate = null; selectedSlot = null;
        document.querySelectorAll('.calendar .day.available').forEach(el=>{ el.classList.remove('selected'); el.setAttribute('aria-selected','false'); });
        document.getElementById('slotsContainer').innerHTML = '';
        // clear form fields
        const form = document.getElementById('bookingForm');
        if (form && typeof form.reset === 'function') { form.reset(); }
        const hidden = document.getElementById('bk_services'); if (hidden) hidden.value = '';
        if (form) form.style.display = 'none';
        // re-render calendar to a clean state
        const calRoot = document.getElementById('calendarContainer'); if (calRoot && calRoot.firstChild) { renderCalendar(new Date()); }
    }

    function showToast(message){
        const t = document.getElementById('toast');
        if (!t) { alert(message); return; }
        t.textContent = message;
        t.classList.add('show');
        setTimeout(()=> t.classList.remove('show'), 2500);
    }
    </script>
</body>
</html>
