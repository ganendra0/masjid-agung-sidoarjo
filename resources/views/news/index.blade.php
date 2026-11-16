@extends('layouts.app')

@section('title', $q ? 'Pencarian: '.$q : 'Berita')
@section('description', 'Berita dan informasi terbaru dari '.$profile->name.'.')
@if ($q || $kategori || $news->currentPage() > 1)
    @section('robots', 'noindex,follow')
@endif

@section('content')
    <x-page-header title="Berita" subtitle="Kabar dan informasi terkini dari lingkungan masjid." :crumbs="['Berita' => null]" />

    <section class="section">
        <div class="container-page">
            <div class="mb-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap gap-2" role="group" aria-label="Filter kategori">
                    @php $chip = 'rounded-full px-5 py-2 text-sm font-semibold shadow-soft ring-1 ring-black/5 transition'; @endphp
                    <a href="{{ route('news.index', array_filter(['q' => $q])) }}"
                       class="{{ $chip }} {{ ! $kategori ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-primary-50 hover:text-primary' }}">Semua</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('news.index', array_filter(['q' => $q, 'kategori' => $category->slug])) }}"
                           class="{{ $chip }} {{ $kategori === $category->slug ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-primary-50 hover:text-primary' }}">{{ $category->name }}</a>
                    @endforeach
                </div>

                <form action="{{ route('news.index') }}" method="GET" role="search" class="flex w-full gap-2 lg:max-w-sm">
                    @if ($kategori)<input type="hidden" name="kategori" value="{{ $kategori }}">@endif
                    <label for="q-berita" class="sr-only">Cari berita</label>
                    <input id="q-berita" type="search" name="q" value="{{ $q }}" maxlength="100" placeholder="Cari berita..." class="input">
                    <button type="submit" class="btn-primary shrink-0" aria-label="Cari"><x-lucide-search class="h-4 w-4" /></button>
                </form>
            </div>

            @if ($q)
                <p class="mb-6 text-sm text-gray-600">{{ $news->total() }} hasil untuk <strong>&ldquo;{{ $q }}&rdquo;</strong></p>
            @endif

            @if ($news->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($news as $item)
                        <x-news-card :news="$item" />
                    @endforeach
                </div>
                {{ $news->links() }}
            @else
                <x-empty-state :message="($q || $kategori) ? 'Tidak ada berita yang cocok dengan pencarian Anda.' : 'Belum ada berita yang dipublikasikan.'"
                               :reset-url="($q || $kategori) ? route('news.index') : null" />
            @endif
        </div>
    </section>
@endsection
