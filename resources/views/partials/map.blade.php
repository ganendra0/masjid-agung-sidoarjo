@if ($contact->safe_maps_url)
    <iframe src="{{ $contact->safe_maps_url }}" title="Peta lokasi {{ $profile->name }}"
            class="border-0 {{ $class ?? 'h-80 w-full' }}" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
@else
    <div class="flex flex-col items-center justify-center gap-4 p-8 text-center {{ $class ?? 'h-80 w-full' }}">
        <x-lucide-map-pin class="h-10 w-10 text-primary" />
        <p class="text-gray-600">Peta belum diatur oleh pengurus.</p>
        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($profile->name) }}"
           target="_blank" rel="noopener" class="btn-outline">Cari di Google Maps</a>
    </div>
@endif
