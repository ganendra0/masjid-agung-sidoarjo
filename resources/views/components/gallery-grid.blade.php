@props(['galleries', 'categories' => collect(), 'filter' => true])
@php
    $items = $galleries->map(fn ($g) => [
        'src' => $g->image_url,
        'title' => $g->title,
        'caption' => $g->caption,
        'cat' => $g->category?->slug ?? 'lainnya',
    ])->values();
@endphp

<div x-data="galleryGrid(@js($items))"
     @keydown.escape.window="open && close()"
     @keydown.arrow-right.window="open && next()"
     @keydown.arrow-left.window="open && prev()">

    @if ($filter && $categories->isNotEmpty())
        <div class="mb-8 flex flex-wrap gap-2" role="group" aria-label="Filter kategori galeri">
            <button type="button" @click="cat = 'all'"
                    :class="cat === 'all' ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-primary-50 hover:text-primary'"
                    class="rounded-full px-5 py-2 text-sm font-semibold shadow-soft ring-1 ring-black/5 transition">Semua</button>
            @foreach ($categories as $category)
                <button type="button" @click="cat = @js($category->slug)"
                        :class="cat === @js($category->slug) ? 'bg-primary text-white' : 'bg-white text-gray-600 hover:bg-primary-50 hover:text-primary'"
                        class="rounded-full px-5 py-2 text-sm font-semibold shadow-soft ring-1 ring-black/5 transition">{{ $category->name }}</button>
            @endforeach
        </div>
    @endif

    <div class="columns-2 gap-4 md:columns-3 lg:columns-4">
        <template x-for="(item, i) in visible" :key="item.src + i">
            <button type="button" @click="show(i)"
                    class="group relative mb-4 block w-full break-inside-avoid overflow-hidden rounded-2xl bg-primary-50 shadow-soft"
                    :aria-label="'Perbesar foto: ' + item.title">
                <img :src="item.src" :alt="item.title" loading="lazy"
                     class="w-full object-cover transition duration-700 group-hover:scale-105">
                <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-primary-dark/80 to-transparent p-4 pt-10 text-left text-sm font-semibold text-white opacity-0 transition duration-300 group-hover:opacity-100 group-focus-visible:opacity-100"
                      x-text="item.title"></span>
            </button>
        </template>
    </div>

    <p x-show="visible.length === 0" x-cloak class="rounded-2xl border border-dashed border-gray-300 p-10 text-center text-gray-500">
        Belum ada foto pada kategori ini.
    </p>

    {{-- Lightbox --}}
    <div x-show="open" x-cloak x-transition.opacity
         class="fixed inset-0 z-[70] flex items-center justify-center bg-black/90 p-4"
         role="dialog" aria-modal="true" aria-label="Pratinjau foto" @click.self="close()">
        <button type="button" @click="close()" class="absolute right-4 top-4 rounded-full bg-white/10 p-3 text-white transition hover:bg-white/25" aria-label="Tutup">
            <x-lucide-x class="h-6 w-6" />
        </button>

        <button type="button" x-show="visible.length > 1" @click="prev()" class="absolute left-3 rounded-full bg-white/10 p-3 text-white transition hover:bg-white/25 sm:left-6" aria-label="Foto sebelumnya">
            <x-lucide-chevron-left class="h-6 w-6" />
        </button>
        <button type="button" x-show="visible.length > 1" @click="next()" class="absolute right-3 rounded-full bg-white/10 p-3 text-white transition hover:bg-white/25 sm:right-6" aria-label="Foto berikutnya">
            <x-lucide-chevron-right class="h-6 w-6" />
        </button>

        <figure class="max-w-5xl">
            <img :src="current.src" :alt="current.title" class="mx-auto max-h-[75vh] w-auto rounded-xl object-contain">
            <figcaption class="mt-4 text-center text-white">
                <span class="block font-bold" x-text="current.title"></span>
                <span class="mt-1 block text-sm text-white/70" x-text="current.caption" x-show="current.caption"></span>
            </figcaption>
        </figure>
    </div>
</div>
