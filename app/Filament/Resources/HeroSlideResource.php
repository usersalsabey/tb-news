<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model           = HeroSlide::class;
    protected static ?string $navigationIcon  = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Hero Slideshow';
    protected static ?string $modelLabel      = 'Slide';
    protected static ?int    $navigationSort  = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Detail Slide')
                ->schema([
                    Forms\Components\Select::make('halaman')
                        ->label('Halaman')
                        ->required()
                        ->options([
                            'beranda'              => 'Beranda',
                            'profil'               => 'Profil',
                            'news'                 => 'Tribratanews',
                            'informasi-pelayanan'  => 'Informasi Pelayanan',
                        ]),

                    Forms\Components\TextInput::make('caption')
                        ->label('Caption')
                        ->nullable()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('urutan')
                        ->label('Urutan')
                        ->numeric()
                        ->default(1),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),

                    Forms\Components\FileUpload::make('foto')
                        ->label('Foto')
                        ->image()
                        ->required()
                        ->disk('public')
                        ->directory('hero-slides')
                        ->maxSize(10240)
                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                        ->helperText('Format JPG/PNG/WEBP, maks. 10MB. Disarankan ukuran landscape 1920×600px.')
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->disk('public')
                    ->height(60)
                    ->width(120),
                Tables\Columns\TextColumn::make('halaman')
                    ->label('Halaman')
                    ->badge()
                    ->formatStateUsing(fn($state) => match($state) {
                        'beranda'             => 'Beranda',
                        'profil'              => 'Profil',
                        'news'                => 'Tribratanews',
                        'informasi-pelayanan' => 'Info Pelayanan',
                        default               => $state,
                    }),
                Tables\Columns\TextColumn::make('caption')
                    ->label('Caption')
                    ->limit(40)
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('halaman')
            ->filters([
                Tables\Filters\SelectFilter::make('halaman')
                    ->options([
                        'beranda'             => 'Beranda',
                        'profil'              => 'Profil',
                        'news'                => 'Tribratanews',
                        'informasi-pelayanan' => 'Informasi Pelayanan',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit'   => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}