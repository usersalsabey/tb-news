<?php

namespace App\Filament\Resources\LaporanWbsResource\Pages;

use App\Filament\Resources\LaporanWbsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaporanWbs extends EditRecord
{
    protected static string $resource = LaporanWbsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
