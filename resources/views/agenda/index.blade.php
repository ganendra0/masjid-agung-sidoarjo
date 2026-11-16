@extends('layouts.app')

@section('title', 'Agenda')
@section('description', 'Agenda kajian dan kegiatan keislaman di '.$profile->name.'.')
@if ($kategori || $tanggal || $tab === 'selesai' || $agendas->currentPage() > 1)
    @section('robots', 'noindex,follow')
@endif

@section('content')
    <x-page-header title="Agenda" subtitle="Jadwal kajian dan kegiatan keislaman di masjid." :crumbs="['Agenda' => null]" />

    <section class="section">
        <div class="container-page">
            {{-- Tab mendatang / terlaksana --}}
            @php $tabClass = 'rounded-full px-6 py-2.5 text-sm font-semibold transition'; @endphp
            <div class="mb-8 inline-flex rounded-full bg-white p-1.5 shadow-soft ring-1 ring-black/5" role="tablist" aria-label="Jenis agenda">
                <a href="{{ route('agenda.index', array_filter(['tab' => 'mendatang', 'kategori' => $kategori, 'tanggal' => $tanggal])) }}"
                   role="tab" aria-selected="{{ $tab === 'mendatang' ? 'true' : 'false' }}"
                   class="{{ $tabClass }} {{ $tab === 'mendatang' ? 'bg-primary text-white' : 'text-gray-600 hover:text-primary' }}">Agenda Mendatang</a>
                <a href="{{ route('agenda.index', array_filter(['tab' => 'selesai', 'kategori' => $kategori, 'tanggal' => $tanggal])) }}"
                   role="tab" aria-selected="{{ $tab === 'selesai' ? 'true' : 'false' }}"
                   class="{{ $tabClass }} {{ $tab === 'selesai' ? 'bg-primary text-white' : 'text-gray-600 hover:text-primary' }}">Telah Terlaksana</a>
            </div>

            {{-- Filter --}}
            <form action="{{ route('agenda.index') }}" method="GET" class="mb-10 grid gap-3 rounded-3xl bg-white p-4 shadow-soft ring-1 ring-black/5 sm:grid-cols-2 lg:grid-cols-4">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div>
                    <label for="f-kategori" class="sr-only">Kategori</label>
                    <select id="f-kategori" name="kategori" class="input">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" @selected($kategori === $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="f-tanggal" class="sr-only">Tanggal</label>
                    <input id="f-tanggal" type="date" name="tanggal" value="{{ $tanggal }}" class="input">
                </div>
                <button type="submit" class="btn-primary">Terapkan Filter</button>
                @if ($kategori || $tanggal)
                    <a href="{{ route('agenda.index', ['tab' => $tab]) }}" class="btn-outline">Atur Ulang</a>
                @endif
            </form>

            @if ($agendas->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($agendas as $agenda)
                        <x-agenda-card :agenda="$agenda" />
                    @endforeach
                </div>
                {{ $agendas->links() }}
            @else
                <x-empty-state :message="($kategori || $tanggal) ? 'Tidak ada agenda yang cocok dengan filter Anda.' : ($tab === 'selesai' ? 'Belum ada agenda yang terlaksana.' : 'Belum ada agenda mendatang.')"
                               :reset-url="($kategori || $tanggal) ? route('agenda.index', ['tab' => $tab]) : null" />
            @endif
        </div>
    </section>
@endsection
