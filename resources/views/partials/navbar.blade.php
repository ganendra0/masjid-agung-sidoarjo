<header x-data="{ open: false, search: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 8"
        @keydown.escape.window="open = false; search = false"
        :class="scrolled ? 'shadow-soft' : ''"
        class="sticky top-0 z-50 border-b border-gray-100 bg-white/90 backdrop-blur transition-shadow duration-300">
    <div class="container-page flex h-16 items-center justify-between lg:h-20">
        <a href="{{ route('home') }}" class="shrink-0" aria-label="{{ $profile->name }} - Beranda">
            <x-logo />
        </a>

        <div class="flex items-center gap-1 lg:gap-2">
            <nav class="hidden items-center gap-1 lg:flex" aria-label="Navigasi utama">
                @foreach ($menu as $item)
                    @php $active = request()->routeIs($item['active']); @endphp
                    <a href="{{ route($item['route']) }}"
                       @if ($active) aria-current="page" @endif
                       class="relative rounded-full px-4 py-2 text-sm font-semibold transition duration-300 {{ $active ? 'bg-primary-50 text-primary' : 'text-gray-600 hover:bg-primary-50 hover:text-primary' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <button type="button" @click="search = !search; open = false; $nextTick(() => $refs.q && $refs.q.focus())"
                    class="rounded-full p-2.5 text-gray-600 transition hover:bg-primary-50 hover:text-primary"
                    :aria-expanded="search" aria-label="Cari berita">
                <x-lucide-search class="h-5 w-5" />
            </button>

            <button type="button" @click="open = !open; search = false"
                    class="rounded-full p-2.5 text-gray-600 transition hover:bg-primary-50 hover:text-primary lg:hidden"
                    :aria-expanded="open" aria-controls="menu-mobile" aria-label="Buka menu">
                <x-lucide-menu class="h-6 w-6" x-show="!open" />
                <x-lucide-x class="h-6 w-6" x-show="open" x-cloak />
            </button>
        </div>
    </div>

    {{-- Panel pencarian --}}
    <div x-show="search" x-cloak x-transition.opacity.duration.200ms class="border-t border-gray-100 bg-white">
        <form action="{{ route('news.index') }}" method="GET" role="search" class="container-page flex items-center gap-3 py-4">
            <label for="cari-berita" class="sr-only">Cari berita</label>
            <input id="cari-berita" x-ref="q" type="search" name="q" maxlength="100" placeholder="Cari berita masjid..."
                   class="w-full rounded-full border-0 bg-surface px-5 py-3 text-sm ring-1 ring-gray-200 focus:ring-2 focus:ring-primary">
            <button type="submit" class="btn-primary shrink-0">Cari</button>
        </form>
    </div>

    {{-- Menu mobile --}}
    <nav id="menu-mobile" x-show="open" x-cloak x-transition.opacity.duration.200ms
         class="border-t border-gray-100 bg-white lg:hidden" aria-label="Navigasi seluler">
        <div class="container-page flex flex-col gap-1 py-4">
            @foreach ($menu as $item)
                @php $active = request()->routeIs($item['active']); @endphp
                <a href="{{ route($item['route']) }}"
                   @if ($active) aria-current="page" @endif
                   class="rounded-xl px-4 py-3 text-sm font-semibold {{ $active ? 'bg-primary-50 text-primary' : 'text-gray-700 hover:bg-surface' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </nav>
</header>
