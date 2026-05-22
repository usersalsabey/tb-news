<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanWbsResource\Pages;
use App\Models\LaporanWbs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LaporanWbsResource extends Resource
{
    protected static ?string $model = LaporanWbs::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';
    protected static ?string $navigationLabel = 'Laporan WBS';
    protected static ?string $modelLabel = 'Laporan WBS';
    protected static ?string $navigationGroup = 'WBS';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Identitas Pelapor')->schema([
                Forms\Components\TextInput::make('nama_pelapor')->label('Nama Pelapor')->disabled(),
                Forms\Components\TextInput::make('nik')->label('NIK')->disabled(),
                Forms\Components\TextInput::make('no_hp')->label('No. HP/WhatsApp')->disabled(),
                Forms\Components\Textarea::make('alamat')->label('Alamat')->disabled(),
            ])->columns(2),

            Forms\Components\Section::make('Informasi Laporan')->schema([
                Forms\Components\TextInput::make('nomor_tiket')->label('Nomor Tiket')->disabled(),
                Forms\Components\TextInput::make('kategori')->label('Kategori')->disabled(),
                Forms\Components\Textarea::make('informasi')->label('Isi Laporan')->disabled()->rows(6),
            ]),

            Forms\Components\Section::make('Dokumen')->schema([
                Forms\Components\TextInput::make('dokumen_utama')->label('Dokumen Utama')->disabled(),
                Forms\Components\TextInput::make('dokumen_tambahan_1')->label('Dokumen Tambahan 1')->disabled(),
                Forms\Components\TextInput::make('dokumen_tambahan_2')->label('Dokumen Tambahan 2')->disabled(),
            ])->columns(3),

            Forms\Components\Section::make('Tindak Lanjut Admin')->schema([
                Forms\Components\Select::make('status')
                    ->label('Status Laporan')
                    ->options([
                        'Diterima' => 'Diterima',
                        'Diproses' => 'Diproses',
                        'Selesai'  => 'Selesai',
                    ])->required(),
                Forms\Components\Textarea::make('catatan_admin')
                    ->label('Catatan Admin')
                    ->rows(4),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nomor_tiket')->label('No. Tiket')->searchable(),
            Tables\Columns\TextColumn::make('nama_pelapor')->label('Nama Pelapor')->searchable(),
            Tables\Columns\TextColumn::make('kategori')->label('Kategori'),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'warning' => 'Diterima',
                    'primary' => 'Diproses',
                    'success' => 'Selesai',
                ]),
            Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime('d/m/Y H:i'),
        ])
        ->defaultSort('created_at', 'desc')
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'Diterima' => 'Diterima',
                    'Diproses' => 'Diproses',
                    'Selesai'  => 'Selesai',
                ]),
            Tables\Filters\SelectFilter::make('kategori')
                ->options([
                    'Penyalahgunaan Wewenang' => 'Penyalahgunaan Wewenang',
                    'Korupsi/Gratifikasi'     => 'Korupsi/Gratifikasi',
                    'Pelanggaran Disiplin'    => 'Pelanggaran Disiplin',
                    'Pungutan Liar (Pungli)'  => 'Pungutan Liar (Pungli)',
                    'Kekerasan/Intimidasi'    => 'Kekerasan/Intimidasi',
                    'Pelanggaran Kode Etik'   => 'Pelanggaran Kode Etik',
                    'Lainnya'                 => 'Lainnya',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make()->label('Detail & Update'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLaporanWbs::route('/'),
            'edit'   => Pages\EditLaporanWbs::route('/{record}/edit'),
        ];
    }
}