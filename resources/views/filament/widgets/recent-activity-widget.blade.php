<x-filament-widgets::widget>
    <x-filament::section heading="Aktivitas Terbaru">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="text-left"><th class="p-2">Jenis</th><th class="p-2">Judul</th><th class="p-2">Status</th><th class="p-2">Dibuat</th></tr></thead>
                <tbody>
                    @forelse ($activities as $activity)
                        <tr class="border-t border-gray-200 dark:border-gray-700"><td class="p-2">{{ $activity['type'] }}</td><td class="p-2">{{ $activity['title'] }}</td><td class="p-2">{{ ucfirst($activity['status']) }}</td><td class="p-2">{{ $activity['created_at']?->diffForHumans() }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="p-4 text-center text-gray-500">Belum ada aktivitas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
