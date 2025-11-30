<?php

namespace App\Filament\Teacher\Resources\MemorizeScoreResource\Pages;

use App\Filament\Teacher\Resources\MemorizeScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMemorizeScores extends ListRecords
{
    protected static string $resource = MemorizeScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
