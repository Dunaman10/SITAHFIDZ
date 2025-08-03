<?php

namespace App\Filament\Teacher\Resources\MemorizeResource\Pages;

use App\Filament\Teacher\Resources\MemorizeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMemorizes extends ListRecords
{
    protected static string $resource = MemorizeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
