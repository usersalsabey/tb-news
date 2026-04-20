<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ProfileResource extends Resource
{
    protected static ?string $model           = Profile::class;
    protected static ?string $navigationIcon  = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Profil Instansi';
    protected static ?string $modelLabel      = 'Profil';
    protected static ?int    $navigationSort  = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Informasi Instansi')
                ->icon('heroicon-o-building-office-2')
                ->schema([
                    Forms\Components\TextInput::make('nama_instansi')
                        ->label('Nama Instansi')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('kapolres')
                        ->label('Nama Kapolres')
                        ->required()
                        ->placeholder('AKBP ...')
                        ->maxLength(255),

                    Forms\Components\Textarea::make('alamat')
                        ->label('Alamat Lengkap')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Foto Pimpinan & Struktur')
                ->icon('heroicon-o-user-circle')
                ->description('Upload foto dalam format JPG/PNG. Foto lama terhapus otomatis saat diganti.')
                ->schema([
                    Forms\Components\FileUpload::make('foto_kapolres')
                        ->label('Foto Kapolres')
                        ->image()
                        ->maxSize(10240)
                        ->directory('profile')
                        ->disk('public')
                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                        ->helperText('Format JPG/PNG, maks. 10MB'),

                    Forms\Components\FileUpload::make('struktur_organisasi')
                        ->label('Foto Struktur Organisasi')
                        ->image()
                        ->maxSize(10240)
                        ->directory('profile')
                        ->disk('public')
                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                        ->helperText('Format JPG/PNG, maks. 10MB'),
                ])->columns(2),

            Forms\Components\Section::make('Visi & Misi')
                ->icon('heroicon-o-star')
                ->schema([
                    Forms\Components\Textarea::make('visi')
                        ->label('Visi')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('misi')
                        ->label('Misi')
                        ->schema([
                            Forms\Components\Textarea::make('isi')
                                ->label('Poin Misi')
                                ->required()
                                ->rows(2),
                        ])
                        ->addActionLabel('+ Tambah Poin Misi')
                        ->reorderable()
                        ->collapsible()
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Sambutan Kapolres')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->schema([
                    Forms\Components\RichEditor::make('sambutan')
                        ->label('Teks Sambutan')
                        ->toolbarButtons([
                            'bold', 'italic', 'underline',
                            'bulletList', 'orderedList',
                            'h2', 'h3', 'link', 'undo', 'redo',
                        ])
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Sejarah')
                ->icon('heroicon-o-book-open')
                ->schema([
                    Forms\Components\RichEditor::make('sejarah')
                        ->label('Sejarah Singkat')
                        ->toolbarButtons([
                            'bold', 'italic', 'underline',
                            'bulletList', 'orderedList',
                            'h2', 'h3',
                            'link', 'blockquote',
                            'undo', 'redo',
                        ])
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_instansi')->label('Instansi'),
                Tables\Columns\TextColumn::make('kapolres')->label('Kapolres'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit Profil'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfiles::route('/'),
            'edit'  => Pages\EditProfile::route('/{record}/edit'),
        ];
    }

    public static function getNavigationUrl(): string
    {
        $profile = Profile::first();
        if ($profile) {
            return route('filament.admin.resources.profiles.edit', ['record' => $profile->id]);
        }
        return route('filament.admin.resources.profiles.index');
    }
}