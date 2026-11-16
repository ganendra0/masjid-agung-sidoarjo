<?php

namespace App\Filament\Resources;

use App\Enums\PublishStatus;
use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Galeri Foto';

    protected static ?string $modelLabel = 'Foto Galeri';

    protected static ?string $pluralModelLabel = 'Galeri Foto';

    protected static string|\UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Foto')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar')
                        ->image()
                        ->disk('public')
                        ->directory('gallery')
                        ->imageEditor()
                        ->maxSize(3072)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->required()
                        ->columnSpanFull()
                        ->helperText('Maksimal 3MB. Format: JPG, PNG, atau WebP.'),
                ]),

            Section::make('Informasi Foto')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Foto')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Select::make('gallery_category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Kategori')
                                ->required(),
                        ]),

                    Forms\Components\DatePicker::make('taken_at')
                        ->label('Tanggal Foto')
                        ->default(today()),

                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options(PublishStatus::options())
                        ->required()
                        ->default(PublishStatus::Published->value)
                        ->native(false),

                    Forms\Components\Textarea::make('caption')
                        ->label('Keterangan Foto')
                        ->maxLength(500)
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->square()
                    ->size(80),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('taken_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (PublishStatus $state) => $state->label())
                    ->colors([
                        'warning' => PublishStatus::Draft->value,
                        'success' => PublishStatus::Published->value,
                    ]),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(PublishStatus::options()),

                SelectFilter::make('gallery_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                EditAction::make()->label('Edit'),
                DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus Terpilih'),
                ]),
            ])
            ->defaultSort('taken_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
