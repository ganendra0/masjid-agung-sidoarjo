@props(['eyebrow' => null, 'title', 'subtitle' => null, 'href' => null, 'linkLabel' => 'Lihat Semua'])
<div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="max-w-2xl">
        @if ($eyebrow)<p class="eyebrow">{{ $eyebrow }}</p>@endif
        <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-primary-dark sm:text-4xl">{{ $title }}</h2>
        @if ($subtitle)<p class="mt-3 text-gray-600">{{ $subtitle }}</p>@endif
    </div>
    @if ($href)
        <a href="{{ $href }}" class="group inline-flex shrink-0 items-center gap-2 text-sm font-semibold text-primary">
            {{ $linkLabel }}
            <x-lucide-arrow-right class="h-4 w-4 transition duration-300 group-hover:translate-x-1" />
        </a>
    @endif
</div>
