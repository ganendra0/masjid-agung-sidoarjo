<?php

namespace App\Filament\Resources;

use App\Enums\PublishStatus;
use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Berita';

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita';

    protected static string|\UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Konten Berita')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Berita')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull()
                        ->live(debounce: 500)
                        ->afterStateUpdated(function (string $operation, $state, Set $set) {
                            if ($operation === 'create') {
                                $set('slug', Str::slug($state));
                            }
                        }),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug URL')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->columnSpanFull()
                        ->helperText('URL artikel, dibuat otomatis dari judul. Jangan ubah jika sudah dipublikasikan.'),

                    Forms\Components\Select::make('news_category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Kategori')
                                ->required(),
                        ]),

                    Forms\Components\Select::make('author_id')
                        ->label('Penulis')
                        ->relationship('author', 'name', fn (Builder $query) => $query->where('is_admin', true))
                        ->searchable()
                        ->preload()
                        ->default(fn () => auth()->id()),

                    Forms\Components\Textarea::make('excerpt')
                        ->label('Ringkasan / Excerpt')
                        ->maxLength(500)
                        ->rows(3)
                        ->columnSpanFull()
                        ->helperText('Ringkasan singkat yang tampil di daftar berita. Jika kosong, diambil otomatis dari konten.'),

                    Forms\Components\RichEditor::make('content')
                        ->label('Isi Berita')
                        ->required()
                        ->columnSpanFull()
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('news/attachments'),
                ])
                ->columns(2),

            Section::make('Gambar Utama')
                ->schema([
                    Forms\Components\FileUpload::make('thumbnail')
                        ->label('Thumbnail / Gambar Utama')
                        ->image()
                        ->disk('public')
                        ->directory('news/thumbnails')
                        ->imageEditor()
                        ->maxSize(2048)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->helperText('Maksimal 2MB. Format: JPG, PNG, atau WebP.')
                        ->columnSpanFull(),
                ]),

            Section::make('Pengaturan Publikasi')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options(PublishStatus::options())
                        ->required()
                        ->default(PublishStatus::Draft->value)
                        ->native(false),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Tanggal Publikasi')
                        ->helperText('Kosongkan untuk publikasi segera saat status diubah ke Published.'),
                ])
                ->columns(2),

            Section::make('SEO (Opsional)')
                ->schema([
                    Forms\Components\TextInput::make('meta_title')
                        ->label('Meta Title')
                        ->maxLength(255)
                        ->columnSpanFull()
                        ->helperText('Judul untuk mesin pencari. Jika kosong, menggunakan judul berita.'),

                    Forms\Components\Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->maxLength(300)
                        ->rows(3)
                        ->columnSpanFull()
                        ->helperText('Deskripsi singkat untuk mesin pencari (maks 300 karakter).'),
                ])
                ->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Foto')
                    ->disk('public')
                    ->square()
                    ->defaultImageUrl(asset('images/placeholder.svg')),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->title),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Penulis')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (PublishStatus $state) => $state->label())
                    ->colors([
                        'warning' => PublishStatus::Draft->value,
                        'success' => PublishStatus::Published->value,
                    ]),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Dipublikasikan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(PublishStatus::options()),

                SelectFilter::make('news_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                ViewAction::make()->label('Lihat'),
                EditAction::make()->label('Edit'),
                DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus Terpilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'view' => Pages\ViewNews::route('/{record}'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
