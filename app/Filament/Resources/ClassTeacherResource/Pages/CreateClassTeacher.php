<?php

namespace App\Filament\Resources\ClassTeacherResource\Pages;

use App\Filament\Resources\ClassTeacherResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateClassTeacher extends CreateRecord
{
  protected static string $resource = ClassTeacherResource::class;

  protected function getRedirectUrl(): string
  {
    return ClassTeacherResource::getUrl('index'); // Redirect ke halaman daftar student
  }

  protected function afterCreate(): void
  {
    Notification::make()
      ->title('Berhasil')
      ->body('Berhasil menambahkan guru dengan kelasnya')
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
