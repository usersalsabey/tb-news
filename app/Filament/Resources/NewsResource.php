<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model            = News::class;
    protected static ?string $navigationIcon   = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup  = 'Konten';
    protected static ?string $navigationLabel  = 'Berita';
    protected static ?string $modelLabel       = 'Berita';
    protected static ?string $pluralModelLabel = 'Berita';
    protected static ?int    $navigationSort   = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            // ── Informasi Utama ──────────────────────────────────────────
            Forms\Components\Section::make('Informasi Utama')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Berita')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) =>
                            $set('slug', Str::slug($state))
                        )
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug URL')
                        ->required()
                        ->unique(News::class, 'slug', ignoreRecord: true)
                        ->maxLength(255)
                        ->helperText('Otomatis terisi dari judul. Jangan diubah manual kecuali perlu.')
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('excerpt')
                        ->label('Ringkasan Berita')
                        ->required()
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('content')
                        ->label('Isi Berita')
                        ->required()
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold', 'italic', 'underline',
                            'bulletList', 'orderedList',
                            'h2', 'h3',
                            'link', 'blockquote',
                            'undo', 'redo',
                        ]),
                ]),

            // ── Kategori & Detail ────────────────────────────────────────
            Forms\Components\Section::make('Kategori & Detail')
                ->schema([
                    Forms\Components\Select::make('category')
                        ->label('Kategori')
                        ->required()
                        ->options([
                            'lalu_lintas' => '🚦 Lalu Lintas',
                            'pelayanan'   => '🆔 Pelayanan',
                            'sosial'      => '🤝 Sosial',
                            'kriminal'    => '🔒 Kriminal',
                            'umum'        => '📰 Umum',
                        ]),

                    Forms\Components\FileUpload::make('icon')
                        ->label('Gambar Thumbnail')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(2048)
                        ->directory('news/thumbnails')
                        ->disk('public')
                        ->imagePreviewHeight('100')
                        ->helperText('Gambar kecil yang mewakili berita ini'),

                    Forms\Components\TextInput::make('source')
                        ->label('Sumber Berita')
                        ->required()
                        ->default('Humas Polres Gunungkidul')
                        ->placeholder('Humas Polres Gunungkidul')
                        ->maxLength(255),

                    Forms\Components\DatePicker::make('published_at')
                        ->label('Tanggal Terbit')
                        ->required()
                        ->default(now()),

                    Forms\Components\Toggle::make('is_published')
                        ->label('Publikasikan Sekarang')
                        ->default(true)
                        ->onColor('success')
                        ->offColor('danger')
                        ->columnSpanFull(),
                ])->columns(2),

            // ── Gambar Berita ────────────────────────────────────────────
            Forms\Components\Section::make('Gambar Berita')
                ->schema([
                    Forms\Components\FileUpload::make('foto')
                        ->label('Upload Gambar (maks. 5 gambar)')
                        ->multiple()
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                        ->maxFiles(5)
                        ->maxSize(5120)
                        ->directory('news')
                        ->disk('public')
                        ->reorderable()
                        ->openable()
                        ->downloadable()
                        ->columnSpanFull(),
                ]),

            // ── Video Berita ─────────────────────────────────────────────
            Forms\Components\Section::make('Video Berita')
                ->icon('heroicon-o-video-camera')
                ->description('Pilih salah satu: upload file video ATAU masukkan URL YouTube/TikTok.')
                ->schema([

                    // Opsi 1 — Upload file video langsung
                    Forms\Components\FileUpload::make('video_path')
                        ->label('Upload File Video')
                        ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                        ->maxSize(102400) // 100 MB
                        ->directory('news/videos')
                        ->disk('public')
                        ->downloadable()
                        ->helperText('Format: MP4, WebM, OGG. Maks. 100 MB.')
                        ->columnSpanFull()
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Kosongkan URL kalau ada file yang diupload
                            if ($state) $set('video_url', null);
                        }),

                    // Divider teks
                    Forms\Components\Placeholder::make('atau')
                        ->label('')
                        ->content('— ATAU masukkan URL YouTube / TikTok —')
                        ->columnSpanFull(),

                    // Opsi 2 — URL YouTube / TikTok
                    Forms\Components\TextInput::make('video_url')
                        ->label('URL YouTube / TikTok')
                        ->url()
                        ->placeholder('https://www.youtube.com/watch?v=... atau https://www.tiktok.com/@.../video/...')
                        ->helperText('Tempel link video YouTube atau TikTok.')
                        ->columnSpanFull()
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Kosongkan file upload kalau URL diisi
                            if ($state) $set('video_path', null);
                        }),

                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->width(60)
                    ->height(40)
                    ->defaultImageUrl(asset('images/no-image.png')),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(55)
                    ->wrap(),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('Kategori')
                    ->colors([
                        'info'    => 'lalu_lintas',
                        'success' => 'pelayanan',
                        'warning' => 'sosial',
                        'danger'  => 'kriminal',
                        'gray'    => 'umum',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'lalu_lintas' => 'Lalu Lintas',
                        'pelayanan'   => 'Pelayanan',
                        'sosial'      => 'Sosial',
                        'kriminal'    => 'Kriminal',
                        'umum'        => 'Umum',
                        default       => $state,
                    }),

                // Kolom indikator video
                Tables\Columns\IconColumn::make('video_url')
                    ->label('Video')
                    ->icon(fn ($state, $record) =>
                        ($state || $record->video_path)
                            ? 'heroicon-o-video-camera'
                            : 'heroicon-o-minus'
                    )
                    ->color(fn ($state, $record) =>
                        ($state || $record->video_path) ? 'success' : 'gray'
                    )
                    ->tooltip(fn ($state, $record) =>
                        $state ? 'URL: ' . $state
                            : ($record->video_path ? 'File upload' : 'Tidak ada video')
                    ),

                Tables\Columns\TextColumn::make('source')
                    ->label('Sumber')
                    ->limit(30)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'lalu_lintas' => 'Lalu Lintas',
                        'pelayanan'   => 'Pelayanan',
                        'sosial'      => 'Sosial',
                        'kriminal'    => 'Kriminal',
                        'umum'        => 'Umum',
                    ]),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->trueLabel('Sudah Publish')
                    ->falseLabel('Draft'),

                // Filter berita yang punya video
                Tables\Filters\Filter::make('has_video')
                    ->label('Ada Video')
                    ->query(fn ($query) => $query->where(function ($q) {
                        $q->whereNotNull('video_url')
                          ->orWhereNotNull('video_path');
                    })),
            ])
            ->actions([
                Tables\Actions\Action::make('toggle')
                    ->label(fn (News $record) => $record->is_published ? 'Sembunyikan' : 'Publikasikan')
                    ->icon(fn (News $record) => $record->is_published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn (News $record) => $record->is_published ? 'warning' : 'success')
                    ->action(fn (News $record) => $record->update(['is_published' => !$record->is_published])),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit'   => Pages\EditNews::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $draft = static::getModel()::where('is_published', false)->count();
        return $draft > 0 ? (string) $draft : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}