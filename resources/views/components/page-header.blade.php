@props(['title', 'subtitle' => null, 'crumbs' => []])
<section class="relative overflow-hidden bg-gradient-to-br from-primary-dark to-primary text-white">
    <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full border-[28px] border-white/5" aria-hidden="true"></div>
    <div class="absolute -bottom-32 right-1/4 h-64 w-64 rounded-full border-[24px] border-gold/10" aria-hidden="true"></div>
    <div class="container-page relative py-14 lg:py-20">
        <x-breadcrumb :crumbs="$crumbs" light />
        <h1 class="mt-5 text-3xl font-extrabold tracking-tight sm:text-4xl lg:text-5xl">{{ $title }}</h1>
        @if ($subtitle)<p class="mt-4 max-w-2xl text-lg text-white/80">{{ $subtitle }}</p>@endif
    </div>
</section>
