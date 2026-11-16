@props(['news'])
<article class="card group flex h-full flex-col overflow-hidden">
    <a href="{{ route('news.show', $news) }}" class="block aspect-[16/10] overflow-hidden bg-primary-50" tabindex="-1" aria-hidden="true">
        <img src="{{ $news->thumbnail_url }}" alt="" loading="lazy" width="640" height="400"
             class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
    </a>

    <div class="flex flex-1 flex-col p-6">
        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
            @if ($news->category)<span class="badge">{{ $news->category->name }}</span>@endif
            <time datetime="{{ optional($news->published_at)->toDateString() }}" class="inline-flex items-center gap-1.5">
                <x-lucide-calendar class="h-3.5 w-3.5" />
                {{ optional($news->published_at ?? $news->created_at)->translatedFormat('d F Y') }}
            </time>
        </div>

        <h3 class="mt-3 text-lg font-bold leading-snug text-primary-dark">
            <a href="{{ route('news.show', $news) }}" class="transition hover:text-primary">{{ $news->title }}</a>
        </h3>
        <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-gray-600">{{ $news->summary }}</p>

        <a href="{{ route('news.show', $news) }}" class="group/link mt-5 inline-flex items-center gap-2 text-sm font-semibold text-primary">
            Baca Selengkapnya
            <x-lucide-arrow-right class="h-4 w-4 transition duration-300 group-hover/link:translate-x-1" />
        </a>
    </div>
</article>
