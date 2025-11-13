<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateActivity extends CreateRecord
{
  protected static string $resource = ActivityResource::class;

  public function getTitle(): string
  {
    return 'Tambah Kegiatan';
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function afterCreate(): void
  {
    Notification::make()
      ->title('Berhasil')
      ->body('Berhasil menambahkan kegiatan baru')
      ->success()
      ->send();
  }
}
