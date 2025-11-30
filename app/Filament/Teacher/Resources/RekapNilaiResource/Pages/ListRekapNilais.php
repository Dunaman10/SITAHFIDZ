<?php

namespace App\Filament\Teacher\Resources\RekapNilaiResource\Pages;

use App\Filament\Teacher\Resources\RekapNilaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekapNilais extends ListRecords
{
  protected static string $resource = RekapNilaiResource::class;

  protected function getHeaderActions(): array
  {
    return [
      // Actions\CreateAction::make(),
    ];
  }
}
