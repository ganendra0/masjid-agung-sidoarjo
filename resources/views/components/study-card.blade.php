@props(['study'])
<article class="card group flex h-full flex-col overflow-hidden">
    <a href="{{ route('studies.show', $study) }}" class="relative block aspect-video overflow-hidden bg-primary-dark" tabindex="-1" aria-hidden="true">
        <img src="{{ $study->thumbnail_url }}" alt="" loading="lazy" width="640" height="360"
             onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'"
             class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
        <span class="absolute inset-0 bg-gradient-to-t from-primary-dark/60 to-transparent"></span>
        <span class="absolute inset-0 flex items-center justify-center">
            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-gold text-primary-dark shadow-lift transition duration-300 group-hover:scale-110">
                <x-lucide-play class="ml-0.5 h-6 w-6" />
            </span>
        </span>
    </a>

    <div class="flex flex-1 flex-col p-6">
        @if ($study->theme)<span class="badge self-start">{{ $study->theme }}</span>@endif

        <h3 class="mt-3 text-lg font-bold leading-snug text-primary-dark">
            <a href="{{ route('studies.show', $study) }}" class="transition hover:text-primary">{{ $study->title }}</a>
        </h3>

        <ul class="mt-4 space-y-2 text-sm text-gray-600">
            <li class="flex items-center gap-2.5"><x-lucide-user class="h-4 w-4 shrink-0 text-primary" /> {{ $study->speaker }}</li>
            <li class="flex items-center gap-2.5"><x-lucide-calendar class="h-4 w-4 shrink-0 text-primary" /> {{ $study->studied_at->translatedFormat('d F Y') }}</li>
        </ul>

        <a href="{{ route('studies.show', $study) }}" class="btn-primary mt-6 self-start">
            <x-lucide-play class="h-4 w-4" /> Tonton Kajian
        </a>
    </div>
</article>
