<?php

namespace App\Filament\Keamanan\Resources\KeamananResource\Pages;

use App\Filament\Keamanan\Resources\KeamananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeamanan extends EditRecord
{
  protected static string $resource = KeamananResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }

  protected function mutateFormDataBeforeFill(array $data): array
  {
    $data['student_name'] = $this->record->student?->student_name;

    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
