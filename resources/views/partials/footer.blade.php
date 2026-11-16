<footer class="mt-auto bg-primary-dark text-white/80">
    <div class="container-page grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <x-logo light />
            <p class="mt-5 text-sm leading-relaxed">
                {{ \App\Support\Text::plain($profile->tagline ?: $profile->description, 160) ?: 'Pusat ibadah, dakwah, pendidikan, dan pelayanan umat.' }}
            </p>
        </div>

        <div>
            <h2 class="text-sm font-bold uppercase tracking-wider text-gold">Tautan Cepat</h2>
            <ul class="mt-5 space-y-3 text-sm">
                @foreach ($menu as $item)
                    <li><a href="{{ route($item['route']) }}" class="transition hover:text-gold">{{ $item['label'] }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h2 class="text-sm font-bold uppercase tracking-wider text-gold">Kontak</h2>
            <div class="mt-5">
                @include('partials.contact-list', ['tone' => 'dark'])
            </div>
        </div>

        <div>
            <h2 class="text-sm font-bold uppercase tracking-wider text-gold">Media Sosial</h2>
            <div class="mt-5">
                @include('partials.social-links', ['tone' => 'dark'])
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <p class="container-page py-5 text-center text-xs text-white/60">
            &copy; {{ now()->year }} {{ $profile->name }}. Seluruh hak cipta dilindungi.
        </p>
    </div>
</footer>
