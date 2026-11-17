<section class="section bg-white" id="profil-singkat">
    @php $profileIntro = $profile->description ?: $profile->tagline; @endphp
    <div class="container-page grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
        <div class="relative">
            <div class="absolute -bottom-4 -left-4 hidden h-full w-full rounded-3xl border-2 border-gold sm:block" aria-hidden="true"></div>
            <img src="{{ $profile->photo_url }}" alt="Foto {{ $profile->name }}" loading="lazy" width="800" height="600"
                 class="relative aspect-[4/3] w-full rounded-3xl object-cover shadow-lift">
            @if ($profile->established_year)
                <div class="absolute -right-2 -top-4 rounded-2xl bg-primary-dark px-5 py-3 text-center text-white shadow-lift sm:-right-4">
                    <span class="block text-xs uppercase tracking-wider text-gold">Berdiri sejak</span>
                    <span class="block text-2xl font-extrabold">{{ $profile->established_year }}</span>
                </div>
            @endif
        </div>

        <div>
            <p class="eyebrow">Profil Masjid</p>
            <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-primary-dark sm:text-4xl">Tentang {{ $profile->name }}</h2>

            @if (filled($profileIntro))
                <p class="mt-5 max-w-xl text-base leading-8 text-gray-600">{{ \App\Support\Text::plain($profileIntro, 220) }}</p>
            @endif

            <a href="{{ route('profile') }}" class="btn-primary mt-6">Selengkapnya <x-lucide-arrow-right class="h-4 w-4" /></a>
        </div>
    </div>
</section>
