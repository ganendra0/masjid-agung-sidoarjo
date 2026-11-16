@extends('layouts.app')

@section('title', 'Kontak')
@section('description', 'Alamat, peta lokasi, dan kontak pengurus '.$profile->name.'.')

@section('content')
    <x-page-header title="Kontak" subtitle="Hubungi pengurus atau kunjungi masjid kami." :crumbs="['Kontak' => null]" />

    <section class="section">
        <div class="container-page grid gap-8 lg:grid-cols-5">
            <div class="space-y-6 lg:col-span-2">
                <div class="card p-7 hover:translate-y-0">
                    <h2 class="mb-5 text-lg font-bold text-primary-dark">Alamat dan Kontak</h2>
                    @include('partials.contact-list', ['tone' => 'light'])

                    <div class="mt-7 flex flex-wrap gap-3">
                        @if ($contact->whatsapp_url)
                            <a href="{{ $contact->whatsapp_url }}" target="_blank" rel="noopener" class="btn-primary">
                                <x-lucide-message-circle class="h-4 w-4" /> Chat WhatsApp
                            </a>
                        @endif
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode(filled($contact->address) && ! str_starts_with($contact->address, '[') ? $contact->address : $profile->name) }}"
                           target="_blank" rel="noopener" class="btn-outline">
                            <x-lucide-navigation class="h-4 w-4" /> Petunjuk Arah
                        </a>
                    </div>
                </div>

                <div class="card p-7 hover:translate-y-0">
                    <h2 class="mb-5 text-lg font-bold text-primary-dark">Media Sosial Resmi</h2>
                    @include('partials.social-links', ['tone' => 'light'])
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl bg-white shadow-soft ring-1 ring-black/5 lg:col-span-3">
                @include('partials.map', ['class' => 'h-96 w-full lg:h-full lg:min-h-[32rem]'])
            </div>
        </div>
    </section>
@endsection
