<?php

namespace App\Filament\Parent\Resources\ProgressHafalanResource\Pages;

use App\Filament\Parent\Resources\ProgressHafalanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgressHafalans extends ListRecords
{
  protected static string $resource = ProgressHafalanResource::class;

  protected function getHeaderActions(): array
  {
    return [
      // Actions\CreateAction::make(),
    ];
  }
}
