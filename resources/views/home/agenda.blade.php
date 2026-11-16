<section class="section" id="agenda">
    <div class="container-page">
        <x-section-heading eyebrow="Agenda"
                           :title="$agendasAreUpcoming ? 'Agenda Mendatang' : 'Agenda Terakhir'"
                           subtitle="Kajian dan kegiatan keislaman yang diselenggarakan di masjid."
                           :href="route('agenda.index')" link-label="Semua Agenda" />

        @if ($agendas->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($agendas as $agenda)
                    <x-agenda-card :agenda="$agenda" />
                @endforeach
            </div>
        @else
            <p class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">Belum ada agenda yang dipublikasikan.</p>
        @endif
    </div>
</section>
