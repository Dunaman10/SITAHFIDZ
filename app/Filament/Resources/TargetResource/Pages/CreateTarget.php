<?php

namespace App\Filament\Resources\TargetResource\Pages;

use App\Filament\Resources\TargetResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTarget extends CreateRecord
{
  protected static string $resource = TargetResource::class;
  public function getTitle(): string
  {
    return 'Tambah Target Baru';
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function afterCreate(): void
  {
    Notification::make()
      ->title('Berhasil')
      ->body('Berhasil menambahkan target baru')
      ->success()
      ->send();
  }

  protected function getCreatedNotification(): ?Notification
  {
    return null;
  }
}
