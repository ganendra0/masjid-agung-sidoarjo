<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MosqueManagerResource\Pages;
use App\Models\MosqueManager;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class MosqueManagerResource extends Resource
{
    protected static ?string $model = MosqueManager::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Struktur Organisasi';

    protected static ?string $modelLabel = 'Pengurus';

    protected static ?string $pluralModelLabel = 'Struktur Organisasi';

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan Website';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Foto Pengurus')
                ->schema([
                    Forms\Components\FileUpload::make('photo')
                        ->label('Foto')
                        ->image()
                        ->disk('public')
                        ->directory('managers')
                        ->imageEditor()
                        ->maxSize(2048)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->columnSpanFull()
                        ->helperText('Disarankan foto berwajah dengan rasio 1:1. Maksimal 2MB.'),
                ]),

            Section::make('Informasi Pengurus')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('position')
                        ->label('Jabatan / Posisi')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Contoh: Ketua Takmir, Sekretaris...'),

                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi Singkat')
                        ->maxLength(500)
                        ->rows(3)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('sort_order')
                        ->label('Urutan Tampilan')
                        ->numeric()
                        ->default(0)
                        ->helperText('Angka lebih kecil tampil lebih dahulu.'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktifkan')
                        ->default(true),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(asset('images/placeholder.svg')),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->filters([])
            ->actions([
                EditAction::make()->label('Edit'),
                DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus Terpilih'),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMosqueManagers::route('/'),
            'create' => Pages\CreateMosqueManager::route('/create'),
            'edit' => Pages\EditMosqueManager::route('/{record}/edit'),
        ];
    }
}
