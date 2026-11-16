<section class="section bg-white" id="galeri">
    <div class="container-page">
        <x-section-heading eyebrow="Galeri"
                           title="Galeri Kegiatan"
                           subtitle="Dokumentasi kegiatan dan suasana di Masjid Agung Sidoarjo." />

        @if ($galleries->isNotEmpty())
            <x-gallery-grid :galleries="$galleries" :categories="$galleryCategories" />
            <div class="mt-10 text-center">
                <a href="{{ route('gallery.index') }}" class="btn-outline">Lihat Semua Galeri</a>
            </div>
        @else
            <p class="rounded-2xl border border-dashed border-gray-300 p-10 text-center text-gray-500">Belum ada foto yang dipublikasikan.</p>
        @endif
    </div>
</section>
