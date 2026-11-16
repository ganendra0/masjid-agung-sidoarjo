@extends('layouts.app')

@section('title', $news->meta_title ?: $news->title)
@section('description', $news->meta_description ?: $news->summary)
@section('image', $news->thumbnail_url)
@section('og_type', 'article')

@push('head')
    <script type="application/ld+json">{!! json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'headline' => $news->title,
        'image' => $news->thumbnail_url,
        'datePublished' => optional($news->published_at ?? $news->created_at)->toAtomString(),
        'dateModified' => $news->updated_at?->toAtomString(),
        'author' => ['@type' => 'Person', 'name' => $news->author?->name ?? $profile->name],
        'publisher' => ['@type' => 'Organization', 'name' => $profile->name],
        'mainEntityOfPage' => url()->current(),
    ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush

@section('content')
    <article class="section pb-8">
        <div class="container-page max-w-3xl">
            <x-breadcrumb :crumbs="['Berita' => route('news.index'), $news->title => null]" />

            @if ($news->category)
                <a href="{{ route('news.index', ['kategori' => $news->category->slug]) }}" class="badge mt-6">{{ $news->category->name }}</a>
            @endif
            <h1 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight text-primary-dark sm:text-4xl">{{ $news->title }}</h1>

            <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-500">
                <span class="inline-flex items-center gap-2"><x-lucide-calendar class="h-4 w-4 text-primary" />
                    <time datetime="{{ optional($news->published_at ?? $news->created_at)->toDateString() }}">{{ optional($news->published_at ?? $news->created_at)->translatedFormat('l, d F Y') }}</time>
                </span>
                <span class="inline-flex items-center gap-2"><x-lucide-user class="h-4 w-4 text-primary" /> {{ $news->author?->name ?? $profile->name }}</span>
            </div>

            <img src="{{ $news->thumbnail_url }}" alt="{{ $news->title }}" width="1200" height="750" fetchpriority="high"
                 class="mt-8 aspect-[16/10] w-full rounded-3xl object-cover shadow-lift">

            <div class="prose prose-lg prose-neutral mt-10 max-w-none prose-headings:text-primary-dark prose-a:text-primary">
                {!! clean($news->content) !!}
            </div>

            <div class="mt-10 border-t border-gray-200 pt-6">
                <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary">
                    <x-lucide-arrow-left class="h-4 w-4" /> Kembali ke daftar berita
                </a>
            </div>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="section bg-white">
            <div class="container-page">
                <x-section-heading eyebrow="Baca Juga" title="Berita Terkait" :href="route('news.index')" link-label="Semua Berita" />
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <x-news-card :news="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
