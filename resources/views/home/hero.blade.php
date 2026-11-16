@php
    $slides = $banners->isNotEmpty()
        ? $banners->map(fn ($b) => [
            'title' => $b->title,
            'subtitle' => $b->subtitle,
            'image' => $b->image_url,
            'label' => $b->button_label ?: 'Lihat Agenda Kajian',
            'link' => $b->button_link ?: route('agenda.index'),
        ])->values()
        : collect([[
            'title' => 'Selamat Datang di '.$profile->name,
            'subtitle' => 'Pusat Ibadah, Dakwah, Pendidikan, dan Pelayanan Umat.',
            'image' => asset('images/placeholder.svg'),
            'label' => 'Lihat Agenda Kajian',
            'link' => route('agenda.index'),
        ]]);
@endphp

<section class="relative isolate overflow-hidden bg-primary-dark"
         x-data="heroSlider({{ $slides->count() }})"
         @mouseenter="paused = true" @mouseleave="paused = false" @focusin="paused = true" @focusout="paused = false"
         aria-roledescription="carousel" aria-label="Banner utama">
    <div class="relative h-[34rem] sm:h-[38rem] lg:h-[44rem]">
        @foreach ($slides as $i => $slide)
            <div class="absolute inset-0 transition-opacity duration-700"
                 :class="current === {{ $i }} ? 'z-10 opacity-100' : 'pointer-events-none z-0 opacity-0'"
                 :aria-hidden="current !== {{ $i }}"
                 role="group" aria-roledescription="slide" aria-label="{{ $i + 1 }} dari {{ $slides->count() }}">
                <img src="{{ $slide['image'] }}" alt="" class="absolute inset-0 h-full w-full object-cover"
                     @if ($i === 0) fetchpriority="high" @else loading="lazy" @endif>
                <div class="absolute inset-0 bg-gradient-to-r from-primary-dark/95 via-primary-dark/70 to-primary-dark/20"></div>
                <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-primary-dark/70 to-transparent"></div>

                <div class="container-page relative flex h-full items-center">
                    <div class="max-w-2xl pb-10 text-white">
                        <p class="eyebrow !text-gold">{{ $profile->name }}</p>
                        @if ($i === 0)
                            <h1 class="mt-4 text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl">{{ $slide['title'] }}</h1>
                        @else
                            <h2 class="mt-4 text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl">{{ $slide['title'] }}</h2>
                        @endif
                        @if ($slide['subtitle'])
                            <p class="mt-5 max-w-xl text-lg leading-relaxed text-white/85">{{ $slide['subtitle'] }}</p>
                        @endif
                        <div class="mt-9 flex flex-wrap gap-3">
                            <a href="{{ route('profile') }}" class="btn-gold">Jelajahi Masjid</a>
                            <a href="{{ $slide['link'] }}" class="btn-light">{{ $slide['label'] }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($slides->count() > 1)
        <button type="button" @click="prev()" class="absolute left-3 top-1/2 z-20 hidden -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur transition hover:bg-white/25 sm:block lg:left-6" aria-label="Banner sebelumnya">
            <x-lucide-chevron-left class="h-6 w-6" />
        </button>
        <button type="button" @click="next()" class="absolute right-3 top-1/2 z-20 hidden -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur transition hover:bg-white/25 sm:block lg:right-6" aria-label="Banner berikutnya">
            <x-lucide-chevron-right class="h-6 w-6" />
        </button>

        <div class="absolute inset-x-0 bottom-6 z-20 flex justify-center gap-2" role="tablist" aria-label="Pilih banner">
            @foreach ($slides as $i => $slide)
                <button type="button" @click="go({{ $i }})" role="tab" :aria-selected="current === {{ $i }}"
                        :class="current === {{ $i }} ? 'w-8 bg-gold' : 'w-2.5 bg-white/50 hover:bg-white'"
                        class="h-2.5 rounded-full transition-all duration-300" aria-label="Banner {{ $i + 1 }}"></button>
            @endforeach
        </div>
    @endif
</section>
