<section class="section bg-white" id="berita">
    <div class="container-page">
        <x-section-heading eyebrow="Berita"
                           title="Berita Terbaru"
                           subtitle="Kabar dan informasi terkini dari lingkungan masjid."
                           :href="route('news.index')" link-label="Semua Berita" />

        @if ($news->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($news as $item)
                    <x-news-card :news="$item" />
                @endforeach
            </div>
        @else
            <p class="rounded-2xl border border-dashed border-gray-300 p-10 text-center text-gray-500">Belum ada berita yang dipublikasikan.</p>
        @endif
    </div>
</section>
