@props(['agenda'])
<article class="card group flex h-full flex-col overflow-hidden">
    <a href="{{ route('agenda.show', $agenda) }}" class="relative block aspect-[16/10] overflow-hidden bg-primary-50" tabindex="-1" aria-hidden="true">
        <img src="{{ $agenda->poster_url }}" alt="" loading="lazy" width="640" height="400"
             class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
        <span class="absolute left-4 top-4 rounded-xl bg-white px-3 py-2 text-center shadow-soft">
            <span class="block text-xl font-extrabold leading-none text-primary-dark">{{ $agenda->starts_at->format('d') }}</span>
            <span class="mt-1 block text-[11px] font-bold uppercase tracking-wider text-gold-dark">{{ $agenda->starts_at->translatedFormat('M Y') }}</span>
        </span>
    </a>

    <div class="flex flex-1 flex-col p-6">
        @if ($agenda->category)
            <span class="badge self-start">{{ $agenda->category->name }}</span>
        @endif

        <h3 class="mt-3 text-lg font-bold leading-snug text-primary-dark">
            <a href="{{ route('agenda.show', $agenda) }}" class="transition hover:text-primary">{{ $agenda->title }}</a>
        </h3>

        <ul class="mt-4 space-y-2.5 text-sm text-gray-600">
            @if ($agenda->speaker)
                <li class="flex items-start gap-2.5"><x-lucide-user class="mt-0.5 h-4 w-4 shrink-0 text-primary" /> <span>{{ $agenda->speaker }}</span></li>
            @endif
            <li class="flex items-start gap-2.5"><x-lucide-calendar class="mt-0.5 h-4 w-4 shrink-0 text-primary" /> <span>{{ $agenda->date_label }}</span></li>
            <li class="flex items-start gap-2.5"><x-lucide-clock class="mt-0.5 h-4 w-4 shrink-0 text-primary" /> <span>{{ $agenda->time_label }}</span></li>
            @if ($agenda->location)
                <li class="flex items-start gap-2.5"><x-lucide-map-pin class="mt-0.5 h-4 w-4 shrink-0 text-primary" /> <span>{{ $agenda->location }}</span></li>
            @endif
        </ul>

        <a href="{{ route('agenda.show', $agenda) }}" class="btn-outline mt-6 self-start">Lihat Detail</a>
    </div>
</article>
