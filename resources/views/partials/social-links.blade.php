@php
    $dark = ($tone ?? 'light') === 'dark';
    $btn = $dark
        ? 'bg-white/10 text-white hover:bg-gold hover:text-primary-dark'
        : 'bg-primary-50 text-primary hover:bg-primary hover:text-white';
@endphp

@if (count($contact->social_links))
    <ul class="flex flex-wrap gap-3">
        @foreach ($contact->social_links as $link)
            <li>
                <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
                   class="flex h-10 w-10 items-center justify-center rounded-full transition duration-300 hover:-translate-y-0.5 {{ $btn }}"
                   aria-label="{{ $link['label'] }}">
                    <x-social-icon :name="$link['key']" class="h-5 w-5" />
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-sm opacity-70">Media sosial belum tersedia.</p>
@endif
