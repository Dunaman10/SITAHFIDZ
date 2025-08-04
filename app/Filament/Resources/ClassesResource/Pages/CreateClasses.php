<?php

namespace App\Filament\Resources\ClassesResource\Pages;

use App\Filament\Resources\ClassesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class CreateClasses extends CreateRecord
{
  protected static string $resource = ClassesResource::class;
  public function getTitle(): string
  {
    return 'Tambah Kelas Baru';
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  protected function afterCreate(): void
  {
    Notification::make()
      ->title('Berhasil')
      ->body('Berhasil menambahkan kelas baru')
      ->success()
      ->send();
  }

  protected function getCreateFormAction(): Action
  {
    return Actions\CreateAction::make()
      ->label('Save')
      ->submit('create')
      ->color('primary');
  }

  protected function getCreateAnotherFormAction(): Action
  {
    return Action::make('createAnother')
      ->hidden();
  }

  protected function getCreatedNotification(): ?Notification
  {
    return null;
  }
}
