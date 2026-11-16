@props(['crumbs' => [], 'light' => false])
<nav aria-label="Breadcrumb" class="text-sm {{ $light ? 'text-white/70' : 'text-gray-500' }}">
    <ol class="flex flex-wrap items-center gap-2">
        <li><a href="{{ route('home') }}" class="transition {{ $light ? 'hover:text-gold' : 'hover:text-primary' }}">Beranda</a></li>
        @foreach ($crumbs as $label => $url)
            <li class="flex items-center gap-2">
                <x-lucide-chevron-right class="h-4 w-4 opacity-60" />
                @if ($url)
                    <a href="{{ $url }}" class="transition {{ $light ? 'hover:text-gold' : 'hover:text-primary' }}">{{ $label }}</a>
                @else
                    <span aria-current="page" class="{{ $light ? 'text-white' : 'font-semibold text-primary-dark' }}">{{ \Illuminate\Support\Str::limit($label, 60) }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
