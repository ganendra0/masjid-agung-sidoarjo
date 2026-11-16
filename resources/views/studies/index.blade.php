@extends('layouts.app')

@section('title', $q ? 'Pencarian kajian: '.$q : 'Arsip Kajian')
@section('description', 'Arsip kajian '.$profile->name.' yang dapat ditonton kembali melalui YouTube.')
@if ($q || $ustadz || $tema || $studies->currentPage() > 1)
    @section('robots', 'noindex,follow')
@endif

@section('content')
    <x-page-header title="Arsip Kajian" subtitle="Tonton kembali kajian yang telah dilaksanakan di masjid." :crumbs="['Kajian' => null]" />

    <section class="section">
        <div class="container-page">
            <form action="{{ route('studies.index') }}" method="GET" role="search"
                  class="mb-10 grid gap-3 rounded-3xl bg-white p-4 shadow-soft ring-1 ring-black/5 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label for="q-kajian" class="sr-only">Cari kajian</label>
                    <input id="q-kajian" type="search" name="q" value="{{ $q }}" maxlength="100" placeholder="Cari judul, ustadz, atau tema..." class="input">
                </div>
                <div>
                    <label for="f-ustadz" class="sr-only">Ustadz</label>
                    <select id="f-ustadz" name="ustadz" class="input">
                        <option value="">Semua ustadz</option>
                        @foreach ($speakers as $speaker)
                            <option value="{{ $speaker }}" @selected($ustadz === $speaker)>{{ $speaker }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="f-tema" class="sr-only">Tema</label>
                    <select id="f-tema" name="tema" class="input">
                        <option value="">Semua tema</option>
                        @foreach ($themes as $theme)
                            <option value="{{ $theme }}" @selected($tema === $theme)>{{ $theme }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn-primary flex-1">Cari</button>
                    @if ($q || $ustadz || $tema)
                        <a href="{{ route('studies.index') }}" class="btn-outline" aria-label="Atur ulang filter"><x-lucide-x class="h-4 w-4" /></a>
                    @endif
                </div>
            </form>

            @if ($studies->isNotEmpty())
                <p class="mb-6 text-sm text-gray-600">Menampilkan {{ $studies->firstItem() }}&ndash;{{ $studies->lastItem() }} dari {{ $studies->total() }} kajian</p>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($studies as $study)
                        <x-study-card :study="$study" />
                    @endforeach
                </div>
                {{ $studies->links() }}
            @else
                <x-empty-state :message="($q || $ustadz || $tema) ? 'Tidak ada kajian yang cocok dengan pencarian Anda.' : 'Belum ada arsip kajian yang dipublikasikan.'"
                               :reset-url="($q || $ustadz || $tema) ? route('studies.index') : null" />
            @endif
        </div>
    </section>
@endsection
