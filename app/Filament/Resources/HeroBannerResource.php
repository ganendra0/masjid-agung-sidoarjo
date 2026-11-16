<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroBannerResource\Pages;
use App\Models\HeroBanner;
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

class HeroBannerResource extends Resource
{
    protected static ?string $model = HeroBanner::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Hero Banner';

    protected static ?string $modelLabel = 'Banner';

    protected static ?string $pluralModelLabel = 'Hero Banner';

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan Website';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Gambar Banner')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar Banner')
                        ->image()
                        ->disk('public')
                        ->directory('banners')
                        ->imageEditor()
                        ->maxSize(3072)
                        ->required()
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->columnSpanFull()
                        ->helperText('Disarankan ukuran 1920x1080px. Maksimal 3MB.'),
                ]),

            Section::make('Konten Banner')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Banner')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('subtitle')
                        ->label('Sub Judul / Tagline')
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('button_label')
                        ->label('Teks Tombol')
                        ->maxLength(100)
                        ->placeholder('Contoh: Lihat Selengkapnya'),

                    Forms\Components\TextInput::make('button_url')
                        ->label('URL Tombol')
                        ->url()
                        ->maxLength(500)
                        ->placeholder('https://... atau /berita'),
                ])
                ->columns(2),

            Section::make('Pengaturan Tampilan')
                ->schema([
                    Forms\Components\TextInput::make('sort_order')
                        ->label('Urutan Tampilan')
                        ->numeric()
                        ->default(0)
                        ->helperText('Angka lebih kecil tampil lebih dahulu.'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktifkan Banner')
                        ->default(true)
                        ->helperText('Banner nonaktif tidak akan tampil di homepage.'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->width(120)
                    ->height(60),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Sub Judul')
                    ->limit(50)
                    ->placeholder('—'),

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
            'index' => Pages\ListHeroBanners::route('/'),
            'create' => Pages\CreateHeroBanner::route('/create'),
            'edit' => Pages\EditHeroBanner::route('/{record}/edit'),
        ];
    }
}
