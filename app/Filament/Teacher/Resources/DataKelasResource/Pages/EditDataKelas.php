<?php

namespace App\Filament\Teacher\Resources\DataKelasResource\Pages;

use App\Filament\Teacher\Resources\DataKelasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataKelas extends EditRecord
{
    protected static string $resource = DataKelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
