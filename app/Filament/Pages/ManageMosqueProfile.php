<?php

namespace App\Filament\Pages;

use App\Models\MosqueProfile;
use Filament\Actions\Action;
use Filament\Forms\Components as Fields;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use UnitEnum;

class ManageMosqueProfile extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-library';

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan Website';

    protected static ?string $navigationLabel = 'Profil Masjid';

    protected static ?string $title = 'Profil Masjid';

    protected string $view = 'filament.pages.manage-mosque-profile';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(MosqueProfile::current()->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Profil Masjid')->schema([
                Fields\TextInput::make('name')->label('Nama Masjid')->required(),
                Fields\TextInput::make('tagline')->label('Tagline'),
                Fields\RichEditor::make('description')
                    ->label('Deskripsi')
                    ->helperText('Tekan Enter untuk membuat paragraf baru. Gunakan toolbar untuk merapikan isi.'),
                Fields\RichEditor::make('history')->label('Sejarah'),
                Fields\Textarea::make('vision')->label('Visi'),
                Fields\RichEditor::make('mission')
                    ->label('Misi')
                    ->helperText('Gunakan Enter untuk paragraf baru dan tombol daftar untuk membuat poin misi.'),
                Fields\Repeater::make('facilities')->label('Fasilitas')->schema([Fields\TextInput::make('name')->required()]),
                Fields\FileUpload::make('photo')->image()->disk('public')->directory('mosque'),
                Fields\TextInput::make('established_year')->numeric(),
            ])->columns(2),
        ])->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [Action::make('save')->label('Simpan')->submit('save')];
    }

    public function save(): void
    {
        MosqueProfile::current()->update($this->form->getState());
        Notification::make()->title('Profil masjid berhasil disimpan')->success()->send();
    }
}
