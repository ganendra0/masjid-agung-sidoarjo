@php
    $siteName = $profile->name ?: 'Masjid Agung Sidoarjo';
    $pageTitle = trim($__env->yieldContent('title'));
    $fullTitle = $pageTitle && $pageTitle !== $siteName ? "{$pageTitle} | {$siteName}" : $siteName;
    $metaDescription = trim($__env->yieldContent('description')) ?: \App\Support\Text::plain($profile->tagline ?: $profile->description, 160);
    $metaImage = trim($__env->yieldContent('image')) ?: asset('images/placeholder.svg');
    $ogType = trim($__env->yieldContent('og_type')) ?: 'website';

    $schema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Mosque',
        'name' => $siteName,
        'url' => url('/'),
        'description' => \App\Support\Text::plain($profile->description, 300) ?: null,
        'image' => $profile->photo_url,
        'telephone' => $contact->phone,
        'email' => $contact->email,
        'address' => filled($contact->address) && ! str_starts_with($contact->address, '[')
            ? ['@type' => 'PostalAddress', 'streetAddress' => $contact->address, 'addressRegion' => 'Jawa Timur', 'addressCountry' => 'ID']
            : null,
        'sameAs' => array_column($contact->social_links, 'url') ?: null,
    ]);
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-pt-20">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    @hasSection('robots')<meta name="robots" content="@yield('robots')">@endif
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-masjid.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
</head>
<body class="flex min-h-screen flex-col">
    <a href="#konten" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2">Lewati ke konten</a>

    @include('partials.navbar')

    <main id="konten" class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
