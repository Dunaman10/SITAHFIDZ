<?php

namespace App\Filament\Resources\ClassesResource\Pages;

use App\Filament\Resources\ClassesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use PhpParser\Node\Stmt\Label;

class ListClasses extends ListRecords
{
  protected static string $resource = ClassesResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()->label('Tambah Kelas'),
    ];
  }
}
