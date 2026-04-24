<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InformasiPelayananResource\Pages;
use App\Models\InformasiPelayanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InformasiPelayananResource extends Resource
{
    protected static ?string $model = InformasiPelayanan::class;
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Informasi Pelayanan';
    protected static ?string $modelLabel = 'Informasi Pelayanan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Dasar')
                ->schema([
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->helperText('Contoh: skck, sim, penerimaan (huruf kecil, tanpa spasi)'),

                    Forms\Components\TextInput::make('kategori')
                        ->label('Kategori (Badge)')
                        ->required()
                        ->helperText('Contoh: SURAT KETERANGAN'),

                    Forms\Components\TextInput::make('judul')
                        ->label('Judul')
                        ->required(),

                    Forms\Components\Textarea::make('deskripsi')
                        ->label('Deskripsi')
                        ->required()
                        ->rows(3),

                    Forms\Components\Select::make('warna')
                        ->label('Warna Tema')
                        ->options([
                            'blue'   => 'Biru',
                            'green'  => 'Hijau',
                            'red'    => 'Merah',
                            'yellow' => 'Kuning',
                            'teal'   => 'Teal',
                            'purple' => 'Ungu',
                        ])
                        ->default('blue')
                        ->required(),

                    Forms\Components\TextInput::make('urutan')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ]),

            Forms\Components\Section::make('Fitur / Poin Layanan')
                ->schema([
                    Forms\Components\Repeater::make('fitur')
                        ->label('Daftar Fitur')
                        ->schema([
                            Forms\Components\TextInput::make('item')
                                ->label('Fitur')
                                ->required(),
                        ])
                        ->defaultItems(1)
                        ->reorderable()
                        ->collapsible(),
                ]),

            Forms\Components\Section::make('Link / Tombol')
                ->schema([
                    Forms\Components\TextInput::make('link_label')
                        ->label('Label Section Link')
                        ->helperText('Contoh: UNDUH APLIKASI, AKSES PORTAL RESMI'),

                    Forms\Components\Repeater::make('links')
                        ->label('Daftar Link')
                        ->schema([
                            Forms\Components\TextInput::make('label')
                                ->label('Teks Tombol')
                                ->required(),
                            Forms\Components\TextInput::make('url')
                                ->label('URL')
                                ->required()
                                ->helperText('Contoh: https://example.com'),
                                // ->url() dihapus karena validasinya terlalu strict untuk URL panjang
                        ])
                        ->defaultItems(1)
                        ->reorderable()
                        ->collapsible(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('urutan')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
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
            'index'  => Pages\ListInformasiPelayanans::route('/'),
            'create' => Pages\CreateInformasiPelayanan::route('/create'),
            'edit'   => Pages\EditInformasiPelayanan::route('/{record}/edit'),
        ];
    }
}