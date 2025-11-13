<?php

namespace App\Filament\Keamanan\Resources\KeamananResource\Pages;

use App\Filament\Keamanan\Resources\KeamananResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeamanans extends ListRecords
{
  protected static string $resource = KeamananResource::class;

  protected function getHeaderActions(): array
  {
    return [
      //
    ];
  }
}
