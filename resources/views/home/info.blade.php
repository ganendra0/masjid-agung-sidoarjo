<section class="section" id="informasi">
    <div class="container-page">
        <x-section-heading eyebrow="Informasi" title="Lokasi dan Kontak"
                           subtitle="Kunjungi kami atau hubungi pengurus masjid." />

        <div class="grid gap-6 lg:grid-cols-5">
            <div class="card space-y-8 p-7 hover:translate-y-0 lg:col-span-2">
                <div>
                    <h3 class="mb-4 font-bold text-primary-dark">Alamat dan Kontak Pengurus</h3>
                    @include('partials.contact-list', ['tone' => 'light'])
                </div>
                <div>
                    <h3 class="mb-4 font-bold text-primary-dark">Media Sosial Resmi</h3>
                    @include('partials.social-links', ['tone' => 'light'])
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="btn-primary">Halaman Kontak</a>
                    @if ($contact->whatsapp_url)
                        <a href="{{ $contact->whatsapp_url }}" target="_blank" rel="noopener" class="btn-outline">
                            <x-lucide-message-circle class="h-4 w-4" /> WhatsApp
                        </a>
                    @endif
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl bg-white shadow-soft ring-1 ring-black/5 lg:col-span-3">
                @include('partials.map', ['class' => 'h-80 w-full lg:h-full lg:min-h-[26rem]'])
            </div>
        </div>
    </div>
</section>
