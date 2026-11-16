@props(['light' => false])
<span class="flex items-center gap-3">
    <img src="{{ asset('images/logo.svg') }}" alt="" width="44" height="44" class="h-10 w-10 lg:h-11 lg:w-11">
    <span class="leading-tight">
        <span class="block text-base font-extrabold lg:text-lg {{ $light ? 'text-white' : 'text-primary-dark' }}">Masjid Agung</span>
        <span class="block text-xs font-semibold uppercase tracking-[0.25em] {{ $light ? 'text-gold' : 'text-gold-dark' }}">Sidoarjo</span>
    </span>
</span>
