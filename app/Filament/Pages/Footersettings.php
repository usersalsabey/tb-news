<?php

namespace App\Filament\Pages;

use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class FooterSettings extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Footer';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int    $navigationSort  = 99;
    protected static string  $view            = 'filament.pages.footer-settings';

    public array $data = [];

    public function mount(): void
    {
        $profile = Profile::first();

        $this->data = [
            'nama_instansi' => $profile?->nama_instansi,
            'alamat'        => $profile?->alamat,
            'telepon'       => $profile?->telepon,
            'email'         => $profile?->email,
            'jam_pelayanan' => $profile?->jam_pelayanan,
            'hotline'       => $profile?->hotline       ?? '110 (Darurat)',
            'maps_url'      => $profile?->maps_url      ?? 'https://maps.app.goo.gl/Xv8tKdyoVjMf4DkRA',
            'copyright'     => $profile?->copyright     ?? '',
            'url_instagram' => $profile?->url_instagram ?? 'https://www.instagram.com/polres.gunungkidul/',
            'url_facebook'  => $profile?->url_facebook  ?? 'https://www.facebook.com/polresgunungkidul',
            'url_youtube'   => $profile?->url_youtube   ?? 'https://www.youtube.com/@polresgunungkidul',
            'url_tiktok'    => $profile?->url_tiktok    ?? 'https://www.tiktok.com/@polres.gunungkidul',
        ];

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Instansi')
                    ->icon('heroicon-o-building-office-2')
                    ->schema([
                        Forms\Components\TextInput::make('nama_instansi')
                            ->label('Nama Instansi')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Alamat & Lokasi')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('maps_url')
                            ->label('Link Google Maps')
                            ->url()
                            ->placeholder('https://maps.app.goo.gl/...')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Kontak')
                    ->icon('heroicon-o-phone')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        Forms\Components\TextInput::make('telepon')
                            ->label('Nomor Telepon')
                            ->tel(),
                        Forms\Components\TextInput::make('hotline')
                            ->label('Hotline Darurat')
                            ->placeholder('110 (Darurat)'),
                        Forms\Components\TextInput::make('jam_pelayanan')
                            ->label('Jam Pelayanan')
                            ->placeholder('24 Jam'),
                    ]),

                Forms\Components\Section::make('Media Sosial')
                    ->icon('heroicon-o-share')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('url_instagram')
                            ->label('Instagram URL')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                        Forms\Components\TextInput::make('url_facebook')
                            ->label('Facebook URL')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                        Forms\Components\TextInput::make('url_youtube')
                            ->label('YouTube URL')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                        Forms\Components\TextInput::make('url_tiktok')
                            ->label('TikTok URL')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                    ]),

                Forms\Components\Section::make('Teks Copyright')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Forms\Components\TextInput::make('copyright')
                            ->label('Teks Copyright (opsional)')
                            ->placeholder('Contoh: Polres Gunungkidul — Melayani Dengan Hati')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [];
    }

    public function save(): void
    {
        $validated = $this->form->getState();

        $profile = Profile::firstOrNew([]);
        $profile->nama_instansi = $validated['nama_instansi'];
        $profile->alamat        = $validated['alamat'];
        $profile->telepon       = $validated['telepon'];
        $profile->email         = $validated['email'];
        $profile->jam_pelayanan = $validated['jam_pelayanan'];
        $profile->hotline       = $validated['hotline'];
        $profile->maps_url      = $validated['maps_url'];
        $profile->copyright     = $validated['copyright'];
        $profile->url_instagram = $validated['url_instagram'];
        $profile->url_facebook  = $validated['url_facebook'];
        $profile->url_youtube   = $validated['url_youtube'];
        $profile->url_tiktok    = $validated['url_tiktok'];
        $profile->save();

        Notification::make()
            ->title('Footer berhasil disimpan!')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->icon('heroicon-o-check')
                ->color('primary')
                ->action('save'),
        ];
    }
}