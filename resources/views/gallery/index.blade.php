@extends('layouts.app')

@section('title', 'Galeri')
@section('description', 'Dokumentasi foto kegiatan di '.$profile->name.'.')
@if ($kategori || $galleries->currentPage() > 1)
    @section('robots', 'noindex,follow')
@endif

@section('content')
    <x-page-header title="Galeri Kegiatan" subtitle="Dokumentasi kegiatan dan suasana di masjid." :crumbs="['Galeri' => null]" />

    <section class="section">
        <div class="container-page">
            @if ($categories->isNotEmpty())
                @php $chip = 'rounded-full px-5 py-2 text-sm font-semibold shadow-soft ring-1 ring-black/5 transition'; @endphp
                <div class="mb-8 flex flex-wrap gap-2" role="group" aria-label="Filter kategori galeri">
                    <a href="{{ route('gallery.index') }}"
                       class="{{ $chip }} {{ ! $kategori ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-primary-50 hover:text-primary' }}">Semua</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('gallery.index', ['kategori' => $category->slug]) }}"
                           class="{{ $chip }} {{ $kategori === $category->slug ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-primary-50 hover:text-primary' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            @endif

            @if ($galleries->isNotEmpty())
                <x-gallery-grid :galleries="$galleries" :filter="false" />
                {{ $galleries->links() }}
            @else
                <x-empty-state :message="$kategori ? 'Belum ada foto pada kategori ini.' : 'Belum ada foto yang dipublikasikan.'"
                               :reset-url="$kategori ? route('gallery.index') : null" />
            @endif
        </div>
    </section>
@endsection
