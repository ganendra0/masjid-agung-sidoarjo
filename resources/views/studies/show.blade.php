@extends('layouts.app')

@section('title', $study->title)
@section('description', \App\Support\Text::plain($study->description, 160) ?: 'Kajian '.$study->speaker.($study->theme ? ' bertema '.$study->theme : '').'.')
@section('image', $study->thumbnail_url)
@section('og_type', 'video.other')

@if ($study->embed_url)
    @push('head')
        <script type="application/ld+json">{!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'VideoObject',
            'name' => $study->title,
            'description' => \App\Support\Text::plain($study->description, 300) ?: $study->title,
            'thumbnailUrl' => $study->thumbnail_url,
            'uploadDate' => $study->studied_at->toDateString(),
            'embedUrl' => $study->embed_url,
        ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @endpush
@endif

@section('content')
    <article class="section pb-8">
        <div class="container-page max-w-4xl">
            <x-breadcrumb :crumbs="['Kajian' => route('studies.index'), $study->title => null]" />

            <div class="mt-8 overflow-hidden rounded-3xl bg-primary-dark shadow-lift">
                @if ($study->embed_url)
                    <div class="aspect-video">
                        <iframe src="{{ $study->embed_url }}" title="{{ $study->title }}" class="h-full w-full border-0" loading="lazy"
                                allow="accelerometer; encrypted-media; picture-in-picture; fullscreen"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                @else
                    <div class="flex aspect-video flex-col items-center justify-center gap-4 p-8 text-center text-white">
                        <x-lucide-video-off class="h-10 w-10 text-gold" />
                        <p>Video tidak dapat ditampilkan karena tautan YouTube belum valid.</p>
                    </div>
                @endif
            </div>

            @if ($study->theme)<span class="badge mt-8">{{ $study->theme }}</span>@endif
            <h1 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight text-primary-dark sm:text-4xl">{{ $study->title }}</h1>

            <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-600">
                <span class="inline-flex items-center gap-2"><x-lucide-user class="h-4 w-4 text-primary" /> {{ $study->speaker }}</span>
                <span class="inline-flex items-center gap-2"><x-lucide-calendar class="h-4 w-4 text-primary" />
                    <time datetime="{{ $study->studied_at->toDateString() }}">{{ $study->studied_at->translatedFormat('l, d F Y') }}</time></span>
            </div>

            @if (filled($study->content) || filled($study->description))
                <div class="prose prose-lg prose-neutral mt-8 max-w-none prose-a:text-primary">{!! clean($study->content ?: $study->description) !!}</div>
            @endif

            @if (preg_match('~^https?://~i', $study->youtube_url))
                <a href="{{ $study->youtube_url }}" target="_blank" rel="noopener noreferrer" class="btn-primary mt-8">
                    <x-lucide-youtube class="h-4 w-4" /> Tonton Kajian di YouTube
                </a>
            @endif
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="section bg-white">
            <div class="container-page">
                <x-section-heading eyebrow="Tonton Juga" title="Kajian Terkait" :href="route('studies.index')" link-label="Semua Kajian" />
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <x-study-card :study="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
