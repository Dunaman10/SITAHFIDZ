<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
  protected static string $resource = UserResource::class;

  public function getTitle(): string
  {
    return 'Buat User Baru'; // Gunakan metode ini untuk mengatur heading
  }

  protected function getRedirectUrl(): string
  {
    return UserResource::getUrl('index'); // Redirect ke halaman daftar student
  }

  protected function afterCreate(): void
  {
    Notification::make()
      ->title('Berhasil')
      ->body('Berhasil menambahkan pengguna')
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
