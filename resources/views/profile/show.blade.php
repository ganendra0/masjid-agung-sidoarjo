@extends('layouts.app')

@section('title', 'Profil')
@section('description', \App\Support\Text::plain($profile->description, 160) ?: 'Profil, sejarah, visi misi, dan fasilitas '.$profile->name.'.')
@section('image', $profile->photo_url)

@section('content')
    <x-page-header title="Profil Masjid" :subtitle="$profile->tagline" :crumbs="['Profil' => null]" />

    {{-- Pengantar --}}
    <section class="section bg-white">
        <div class="container-page grid items-start gap-12 lg:grid-cols-5">
            <div class="lg:col-span-2">
                <img src="{{ $profile->photo_url }}" alt="Foto {{ $profile->name }}" width="800" height="600"
                     class="aspect-[4/3] w-full rounded-3xl object-cover shadow-lift">
            </div>
            <div class="lg:col-span-3">
                <p class="eyebrow">Tentang Kami</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-primary-dark">{{ $profile->name }}</h2>
                @if (filled($profile->description))
                    <div class="prose prose-neutral mt-5 max-w-none prose-a:text-primary">{!! clean($profile->description) !!}</div>
                @endif

                <dl class="mt-8 grid gap-4 sm:grid-cols-2">
                    @if ($profile->established_year)
                        <div class="rounded-2xl bg-surface p-5">
                            <dt class="text-xs font-bold uppercase tracking-wider text-gold-dark">Tahun Berdiri</dt>
                            <dd class="mt-1 text-lg font-bold text-primary-dark">{{ $profile->established_year }}</dd>
                        </div>
                    @endif
                    @if (filled($contact->address))
                        <div class="rounded-2xl bg-surface p-5">
                            <dt class="text-xs font-bold uppercase tracking-wider text-gold-dark">Alamat</dt>
                            <dd class="mt-1 font-semibold text-primary-dark">{{ $contact->address }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </section>

    {{-- Sejarah --}}
    @if (filled($profile->history))
        <section class="section" id="sejarah">
            <div class="container-page max-w-4xl">
                <p class="eyebrow">Sejarah</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-primary-dark">Sejarah Berdirinya Masjid</h2>
                <div class="prose prose-neutral mt-6 max-w-none prose-a:text-primary">{!! clean($profile->history) !!}</div>
            </div>
        </section>
    @endif

    {{-- Visi dan misi --}}
    @if (filled($profile->vision) || filled($profile->mission))
        <section class="section bg-white" id="visi-misi">
            <div class="container-page">
                <x-section-heading eyebrow="Arah dan Tujuan" title="Visi dan Misi" />
                <div class="grid gap-6 lg:grid-cols-2">
                    @if (filled($profile->vision))
                        <div class="rounded-3xl bg-primary-dark p-8 text-white">
                            <x-lucide-eye class="h-8 w-8 text-gold" />
                            <h3 class="mt-4 text-xl font-bold">Visi</h3>
                            <p class="mt-3 leading-relaxed text-white/85">{!! nl2br(e($profile->vision)) !!}</p>
                        </div>
                    @endif
                    @if (filled($profile->mission))
                        <div class="rounded-3xl bg-primary-50 p-8">
                            <x-lucide-target class="h-8 w-8 text-primary" />
                            <h3 class="mt-4 text-xl font-bold text-primary-dark">Misi</h3>
                            <div class="prose prose-neutral mt-3 max-w-none">{!! clean($profile->mission) !!}</div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- Struktur organisasi --}}
    <section class="section" id="struktur">
        <div class="container-page">
            <x-section-heading eyebrow="Organisasi" title="Struktur Pengurus Masjid" />

            @if ($managers->isNotEmpty())
                <div class="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-4">
                    @foreach ($managers as $manager)
                        <div class="card p-6 text-center">
                            <img src="{{ $manager->photo_url }}" alt="Foto {{ $manager->name }}" loading="lazy" width="112" height="112"
                                 class="mx-auto h-28 w-28 rounded-full object-cover ring-4 ring-primary-50">
                            <h3 class="mt-4 font-bold text-primary-dark">{{ $manager->name }}</h3>
                            <p class="mt-1 text-sm font-semibold text-gold-dark">{{ $manager->position }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state message="Struktur pengurus belum diisi." />
            @endif
        </div>
    </section>

    {{-- Fasilitas --}}
    <section class="section bg-white" id="fasilitas">
        <div class="container-page">
            <x-section-heading eyebrow="Fasilitas" title="Fasilitas Masjid" />

            @if ($facilities->isNotEmpty())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($facilities as $facility)
                        <div class="rounded-2xl bg-surface p-6">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary text-white"><x-lucide-building-2 class="h-5 w-5" /></span>
                            <h3 class="mt-4 font-bold text-primary-dark">{{ $facility['name'] }}</h3>
                            @if (filled($facility['description'] ?? null))
                                <p class="mt-2 text-sm leading-relaxed text-gray-600">{{ $facility['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state message="Daftar fasilitas belum diisi." />
            @endif

            <div class="mt-12 text-center">
                <a href="{{ route('contact') }}" class="btn-primary">Hubungi Pengurus</a>
            </div>
        </div>
    </section>
@endsection
