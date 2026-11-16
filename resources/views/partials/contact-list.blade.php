@php
    $dark = ($tone ?? 'light') === 'dark';
    $iconBox = $dark ? 'bg-white/10 text-gold' : 'bg-primary-50 text-primary';
    $linkClass = $dark ? 'hover:text-gold' : 'hover:text-primary';
    $rows = array_filter([
        'address' => filled($contact->address) ? ['icon' => 'map-pin', 'text' => $contact->address, 'href' => null] : null,
        'phone' => filled($contact->phone) ? ['icon' => 'phone', 'text' => $contact->phone, 'href' => $contact->tel_url] : null,
        'whatsapp' => $contact->whatsapp_url ? ['icon' => 'message-circle', 'text' => 'WhatsApp: '.$contact->whatsapp, 'href' => $contact->whatsapp_url] : null,
        'email' => filled($contact->email) ? ['icon' => 'mail', 'text' => $contact->email, 'href' => 'mailto:'.$contact->email] : null,
    ]);
@endphp

@if ($rows)
    <ul class="space-y-4 text-sm">
        @foreach ($rows as $row)
            <li class="flex items-start gap-3">
                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $iconBox }}">
                    <x-dynamic-component :component="'lucide-'.$row['icon']" class="h-4 w-4" />
                </span>
                @if ($row['href'])
                    <a href="{{ $row['href'] }}" @if (str_starts_with($row['href'], 'https://wa.me')) target="_blank" rel="noopener" @endif
                       class="self-center break-words transition {{ $linkClass }}">{{ $row['text'] }}</a>
                @else
                    <span class="self-center">{{ $row['text'] }}</span>
                @endif
            </li>
        @endforeach
    </ul>
@else
    <p class="text-sm opacity-70">Informasi kontak belum tersedia.</p>
@endif
