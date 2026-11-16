<x-filament-widgets::widget>
    <x-filament::section heading="Aksi Cepat">
        <div class="flex flex-wrap gap-3">
            <x-filament::button :href="\App\Filament\Resources\NewsResource::getUrl('create')" tag="a" icon="heroicon-o-plus">Tambah Berita</x-filament::button>
            <x-filament::button :href="\App\Filament\Resources\AgendaResource::getUrl('create')" tag="a" icon="heroicon-o-plus">Tambah Agenda</x-filament::button>
            <x-filament::button :href="\App\Filament\Resources\StudyResource::getUrl('create')" tag="a" icon="heroicon-o-plus">Tambah Kajian</x-filament::button>
            <x-filament::button :href="\App\Filament\Resources\GalleryResource::getUrl('create')" tag="a" icon="heroicon-o-plus">Tambah Galeri</x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
