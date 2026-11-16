@extends('layouts.app')

@php
    $calendarUrl = 'https://calendar.google.com/calendar/render?'.http_build_query(array_filter([
        'action' => 'TEMPLATE',
        'text' => $agenda->title,
        'dates' => $agenda->starts_at->copy()->utc()->format('Ymd\THis\Z').'/'.($agenda->ends_at ?? $agenda->starts_at->copy()->addHours(2))->copy()->utc()->format('Ymd\THis\Z'),
        'location' => $agenda->location,
        'details' => \App\Support\Text::plain($agenda->description, 300) ?: null,
    ]));
@endphp

@section('title', $agenda->title)
@section('description', \App\Support\Text::plain($agenda->description, 160) ?: $agenda->title.' - '.$agenda->date_label)
@section('image', $agenda->poster_url)

@push('head')
    <script type="application/ld+json">{!! json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Event',
        'name' => $agenda->title,
        'startDate' => $agenda->starts_at->toAtomString(),
        'endDate' => $agenda->ends_at?->toAtomString(),
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        'location' => ['@type' => 'Place', 'name' => $agenda->location ?: $profile->name],
        'image' => $agenda->poster_url,
        'performer' => $agenda->speaker ? ['@type' => 'Person', 'name' => $agenda->speaker] : null,
        'organizer' => ['@type' => 'Organization', 'name' => $profile->name],
    ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush

@section('content')
    <section class="section pb-8">
        <div class="container-page">
            <x-breadcrumb :crumbs="['Agenda' => route('agenda.index'), $agenda->title => null]" />

            <div class="mt-8 grid items-start gap-10 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="flex flex-wrap items-center gap-2">
                        @if ($agenda->category)<span class="badge">{{ $agenda->category->name }}</span>@endif
                        <span class="badge {{ $agenda->is_past ? '!bg-gray-100 !text-gray-600' : '' }}">{{ $agenda->is_past ? 'Telah terlaksana' : 'Akan datang' }}</span>
                    </div>
                    <h1 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight text-primary-dark sm:text-4xl">{{ $agenda->title }}</h1>

                    <img src="{{ $agenda->poster_url }}" alt="Poster {{ $agenda->title }}" width="1200" height="750" fetchpriority="high"
                         class="mt-8 w-full rounded-3xl object-cover shadow-lift">

                    @if (filled($agenda->description))
                        <div class="prose prose-lg prose-neutral mt-10 max-w-none prose-headings:text-primary-dark prose-a:text-primary">
                            {!! clean($agenda->description) !!}
                        </div>
                    @endif
                </div>

                <aside class="lg:sticky lg:top-28">
                    <div class="card p-7 hover:translate-y-0">
                        <h2 class="text-lg font-bold text-primary-dark">Informasi Kegiatan</h2>
                        <ul class="mt-5 space-y-5 text-sm">
                            @if ($agenda->speaker)
                                <li class="flex gap-3"><x-lucide-user class="mt-0.5 h-5 w-5 shrink-0 text-primary" />
                                    <div><span class="block text-xs font-bold uppercase tracking-wider text-gold-dark">Pemateri</span>{{ $agenda->speaker }}</div></li>
                            @endif
                            <li class="flex gap-3"><x-lucide-calendar class="mt-0.5 h-5 w-5 shrink-0 text-primary" />
                                <div><span class="block text-xs font-bold uppercase tracking-wider text-gold-dark">Tanggal</span>{{ $agenda->date_label }}</div></li>
                            <li class="flex gap-3"><x-lucide-clock class="mt-0.5 h-5 w-5 shrink-0 text-primary" />
                                <div><span class="block text-xs font-bold uppercase tracking-wider text-gold-dark">Waktu</span>{{ $agenda->time_label }}</div></li>
                            @if ($agenda->location)
                                <li class="flex gap-3"><x-lucide-map-pin class="mt-0.5 h-5 w-5 shrink-0 text-primary" />
                                    <div><span class="block text-xs font-bold uppercase tracking-wider text-gold-dark">Lokasi</span>{{ $agenda->location }}</div></li>
                            @endif
                        </ul>

                        @unless ($agenda->is_past)
                            <a href="{{ $calendarUrl }}" target="_blank" rel="noopener" class="btn-primary mt-7 w-full">
                                <x-lucide-calendar-plus class="h-4 w-4" /> Tambahkan ke Kalender
                            </a>
                        @endunless
                        <a href="{{ route('agenda.index') }}" class="btn-outline mt-3 w-full">Semua Agenda</a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @if ($others->isNotEmpty())
        <section class="section bg-white">
            <div class="container-page">
                <x-section-heading eyebrow="Jangan Terlewat" title="Agenda Mendatang Lainnya" :href="route('agenda.index')" link-label="Semua Agenda" />
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($others as $item)
                        <x-agenda-card :agenda="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
