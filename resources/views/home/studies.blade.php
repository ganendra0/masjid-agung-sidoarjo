<section class="section" id="kajian">
    <div class="container-page">
        <x-section-heading eyebrow="Riwayat Kajian"
                           title="Arsip Kajian"
                           subtitle="Tonton kembali kajian yang telah dilaksanakan."
                           :href="route('studies.index')" link-label="Semua Kajian" />

        @if ($studies->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($studies as $study)
                    <x-study-card :study="$study" />
                @endforeach
            </div>
        @else
            <p class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">Belum ada arsip kajian yang dipublikasikan.</p>
        @endif
    </div>
</section>
