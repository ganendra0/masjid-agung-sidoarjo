<?php

namespace App\Filament\Resources;

use App\Enums\PublishStatus;
use App\Filament\Resources\AgendaResource\Pages;
use App\Models\Agenda;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class AgendaResource extends Resource
{
    protected static ?string $model = Agenda::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Agenda';

    protected static ?string $modelLabel = 'Agenda';

    protected static ?string $pluralModelLabel = 'Agenda';

    protected static string|\UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Agenda')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Agenda')
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
                        ->columnSpanFull(),

                    Forms\Components\Select::make('agenda_category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Kategori')
                                ->required(),
                        ]),

                    Forms\Components\TextInput::make('speaker')
                        ->label('Pemateri / Narasumber')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('location')
                        ->label('Lokasi')
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('description')
                        ->label('Deskripsi Agenda')
                        ->columnSpanFull()
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('agenda/attachments'),
                ])
                ->columns(2),

            Section::make('Waktu Pelaksanaan')
                ->schema([
                    Forms\Components\DateTimePicker::make('starts_at')
                        ->label('Waktu Mulai')
                        ->required()
                        ->seconds(false),

                    Forms\Components\DateTimePicker::make('ends_at')
                        ->label('Waktu Selesai')
                        ->seconds(false)
                        ->helperText('Opsional. Biarkan kosong jika waktu selesai belum ditentukan.')
                        ->after('starts_at'),
                ])
                ->columns(2),

            Section::make('Poster / Gambar')
                ->schema([
                    Forms\Components\FileUpload::make('poster')
                        ->label('Poster Agenda')
                        ->image()
                        ->disk('public')
                        ->directory('agenda/posters')
                        ->imageEditor()
                        ->maxSize(2048)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->columnSpanFull(),
                ]),

            Section::make('Status Publikasi')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options(PublishStatus::options())
                        ->required()
                        ->default(PublishStatus::Draft->value)
                        ->native(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('poster')
                    ->label('Poster')
                    ->disk('public')
                    ->square()
                    ->defaultImageUrl(asset('images/placeholder.svg')),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(55),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('speaker')
                    ->label('Pemateri')
                    ->searchable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_past')
                    ->label('Status Waktu')
                    ->boolean()
                    ->trueIcon('heroicon-o-clock')
                    ->falseIcon('heroicon-o-calendar')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->tooltip(fn ($record) => $record->is_past ? 'Sudah berlalu' : 'Mendatang'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Publikasi')
                    ->formatStateUsing(fn (PublishStatus $state) => $state->label())
                    ->colors([
                        'warning' => PublishStatus::Draft->value,
                        'success' => PublishStatus::Published->value,
                    ]),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Publikasi')
                    ->options(PublishStatus::options()),

                SelectFilter::make('agenda_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),

                Filter::make('upcoming')
                    ->label('Hanya Mendatang')
                    ->query(fn (Builder $query) => $query->upcoming()),

                Filter::make('past')
                    ->label('Hanya Yang Berlalu')
                    ->query(fn (Builder $query) => $query->past()),
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
            ->defaultSort('starts_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgendas::route('/'),
            'create' => Pages\CreateAgenda::route('/create'),
            'view' => Pages\ViewAgenda::route('/{record}'),
            'edit' => Pages\EditAgenda::route('/{record}/edit'),
        ];
    }
}
