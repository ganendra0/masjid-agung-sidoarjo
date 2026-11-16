<?php

namespace App\Filament\Resources;

use App\Enums\PublishStatus;
use App\Filament\Resources\StudyResource\Pages;
use App\Models\Study;
use App\Support\YouTube;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class StudyResource extends Resource
{
    protected static ?string $model = Study::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Arsip Kajian';

    protected static ?string $modelLabel = 'Kajian';

    protected static ?string $pluralModelLabel = 'Arsip Kajian';

    protected static string|\UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Kajian')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Kajian')
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

                    Forms\Components\TextInput::make('speaker')
                        ->label('Nama Ustadz / Pemateri')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('theme')
                        ->label('Tema Kajian')
                        ->maxLength(255)
                        ->placeholder('Contoh: Fiqh, Tauhid, Sirah Nabawiyah...'),

                    Forms\Components\DatePicker::make('studied_at')
                        ->label('Tanggal Kajian')
                        ->required()
                        ->default(today()),

                    Forms\Components\TextInput::make('youtube_url')
                        ->label('Link YouTube')
                        ->required()
                        ->url()
                        ->maxLength(500)
                        ->columnSpanFull()
                        ->placeholder('https://www.youtube.com/watch?v=...')
                        ->helperText('Masukkan URL video YouTube. ID video akan diekstrak otomatis.')
                        ->rule(fn (): \Closure => function (string $attribute, mixed $value, \Closure $fail): void {
                            if (! YouTube::extractId($value)) {
                                $fail('URL YouTube tidak valid. Pastikan link mengarah ke video YouTube yang benar.');
                            }
                        })
                        ->live(debounce: 800)
                        ->afterStateUpdated(function ($state, Set $set) {
                            $id = YouTube::extractId($state);
                            if ($id) {
                                $set('youtube_id', $id);
                            }
                        }),

                    Forms\Components\TextInput::make('youtube_id')
                        ->label('ID Video YouTube')
                        ->maxLength(20)
                        ->disabled()
                        ->dehydrated()
                        ->helperText('Diisi otomatis dari URL YouTube.')
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('description')
                        ->label('Ringkasan Kajian')
                        ->rows(3)
                        ->columnSpanFull()
                        ->helperText('Ringkasan singkat yang tampil di daftar kajian.'),
                ])
                ->columns(3),

            Section::make('Isi Kajian')
                ->description('Tulis naskah atau rangkuman lengkap kajian. Isi ini akan tampil seperti artikel pada halaman detail.')
                ->schema([
                    Forms\Components\RichEditor::make('content')
                        ->label('Naskah Kajian')
                        ->columnSpanFull()
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('studies/attachments'),
                ]),

            Section::make('Pratinjau Video')
                ->schema([
                    Forms\Components\Placeholder::make('youtube_preview')
                        ->label('')
                        ->content(function (Get $get) {
                            $id = $get('youtube_id') ?: YouTube::extractId($get('youtube_url') ?? '');

                            if (! $id) {
                                return 'Masukkan URL YouTube untuk melihat pratinjau.';
                            }

                            $thumb = YouTube::thumbnail($id);
                            $embed = YouTube::embedUrl($id);

                            return new HtmlString(
                                "<div class='space-y-2'>"
                                ."<img src='{$thumb}' alt='Thumbnail' class='rounded-lg w-full max-w-sm'>"
                                .'</div>'
                            );
                        })
                        ->columnSpanFull(),
                ])
                ->collapsible(),

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
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->defaultImageUrl(asset('images/placeholder.svg')),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(55),

                Tables\Columns\TextColumn::make('speaker')
                    ->label('Pemateri')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('theme')
                    ->label('Tema')
                    ->badge()
                    ->color('info')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('studied_at')
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

                SelectFilter::make('speaker')
                    ->label('Pemateri')
                    ->options(fn () => Study::query()->distinct()->pluck('speaker', 'speaker')->toArray()),

                SelectFilter::make('theme')
                    ->label('Tema')
                    ->options(fn () => Study::query()->whereNotNull('theme')->distinct()->pluck('theme', 'theme')->toArray()),
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
            ->defaultSort('studied_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudies::route('/'),
            'create' => Pages\CreateStudy::route('/create'),
            'view' => Pages\ViewStudy::route('/{record}'),
            'edit' => Pages\EditStudy::route('/{record}/edit'),
        ];
    }
}
