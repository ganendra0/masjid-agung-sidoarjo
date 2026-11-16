<section class="section bg-white" id="profil-singkat">
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

            @if (filled($profile->description))
                <p class="mt-5 leading-relaxed text-gray-600">{{ \App\Support\Text::plain($profile->description, 380) }}</p>
            @endif

            @if (filled($profile->history))
                <div class="mt-6 rounded-2xl bg-surface p-5">
                    <h3 class="flex items-center gap-2 font-bold text-primary-dark"><x-lucide-landmark class="h-5 w-5 text-primary" /> Sejarah Singkat</h3>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">{{ \App\Support\Text::plain($profile->history, 260) }}</p>
                </div>
            @endif

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                @if (filled($profile->vision))
                    <div class="rounded-2xl bg-primary-50 p-5">
                        <h3 class="flex items-center gap-2 font-bold text-primary-dark"><x-lucide-eye class="h-5 w-5 text-primary" /> Visi</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-700">{{ \App\Support\Text::plain($profile->vision, 200) }}</p>
                    </div>
                @endif
                @if (filled($profile->mission))
                    <div class="rounded-2xl bg-primary-50 p-5">
                        <h3 class="flex items-center gap-2 font-bold text-primary-dark"><x-lucide-target class="h-5 w-5 text-primary" /> Misi</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-700">{{ \App\Support\Text::plain($profile->mission, 200) }}</p>
                    </div>
                @endif
            </div>

            <a href="{{ route('profile') }}" class="btn-primary mt-8">Selengkapnya <x-lucide-arrow-right class="h-4 w-4" /></a>
        </div>
    </div>
</section>
