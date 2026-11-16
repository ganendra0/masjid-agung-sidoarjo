@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman" class="mt-12 flex flex-wrap items-center justify-center gap-2">
        @php
            $base = 'inline-flex h-11 min-w-[2.75rem] items-center justify-center rounded-full px-4 text-sm font-semibold transition';
        @endphp

        @if ($paginator->onFirstPage())
            <span class="{{ $base }} cursor-not-allowed bg-white text-gray-300 ring-1 ring-black/5" aria-disabled="true"><x-lucide-chevron-left class="h-4 w-4" /><span class="sr-only">Sebelumnya</span></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $base }} bg-white text-gray-700 shadow-soft ring-1 ring-black/5 hover:bg-primary hover:text-white"><x-lucide-chevron-left class="h-4 w-4" /><span class="sr-only">Sebelumnya</span></a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="{{ $base }} text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="{{ $base }} bg-primary text-white shadow-soft">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="{{ $base }} bg-white text-gray-700 shadow-soft ring-1 ring-black/5 hover:bg-primary-50 hover:text-primary" aria-label="Ke halaman {{ $page }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $base }} bg-white text-gray-700 shadow-soft ring-1 ring-black/5 hover:bg-primary hover:text-white"><x-lucide-chevron-right class="h-4 w-4" /><span class="sr-only">Berikutnya</span></a>
        @else
            <span class="{{ $base }} cursor-not-allowed bg-white text-gray-300 ring-1 ring-black/5" aria-disabled="true"><x-lucide-chevron-right class="h-4 w-4" /><span class="sr-only">Berikutnya</span></span>
        @endif
    </nav>
@endif
