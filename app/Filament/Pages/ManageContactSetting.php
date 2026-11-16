<?php

namespace App\Filament\Pages;

use App\Models\ContactSetting;
use Filament\Actions\Action;
use Filament\Forms\Components as Fields;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use UnitEnum;

class ManageContactSetting extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-phone';

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan Website';

    protected static ?string $navigationLabel = 'Kontak & Sosial Media';

    protected static ?string $title = 'Kontak & Sosial Media';

    protected string $view = 'filament.pages.manage-contact-setting';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(ContactSetting::current()->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Kontak')->schema([
                Fields\Textarea::make('address')->label('Alamat'),
                Fields\TextInput::make('phone')->label('Telepon'),
                Fields\TextInput::make('whatsapp')->label('WhatsApp'),
                Fields\TextInput::make('email')->email()->label('Email'),
                Fields\TextInput::make('maps_embed_url')->url()->label('URL Embed Google Maps'),
                Fields\TextInput::make('instagram')->url(),
                Fields\TextInput::make('facebook')->url(),
                Fields\TextInput::make('youtube')->url(),
                Fields\TextInput::make('tiktok')->url(),
            ])->columns(2),
        ])->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [Action::make('save')->label('Simpan')->submit('save')];
    }

    public function save(): void
    {
        ContactSetting::current()->update($this->form->getState());
        Notification::make()->title('Kontak berhasil disimpan')->success()->send();
    }
}
