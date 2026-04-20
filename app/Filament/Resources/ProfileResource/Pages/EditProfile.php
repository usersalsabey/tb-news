<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tidak ada delete — profil tidak boleh dihapus
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Setelah save, tetap di halaman edit
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Profil berhasil disimpan!')
            ->body('Perubahan telah tersimpan ke database.');
    }

    // app/Filament/Resources/ProfileResource/Pages/EditProfile.php
    public function mount(int | string $record): void
    {
    set_time_limit(300); // sementara untuk debug
    parent::mount($record);
    }
}