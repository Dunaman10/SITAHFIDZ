<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\StudentResource;

class CreateStudent extends CreateRecord
{
  protected static string $resource = StudentResource::class;

  protected function getCreatedNotification(): ?Notification
  {
    return null;
  }

  //✅ Ganti dengan notifikasi buatan sendiri
  protected function afterCreate(): void
  {
    Notification::make()
      ->title('Berhasil')
      ->body('Berhasil menambahkan santri baru')
      ->success()
      ->send();

    ///direct ke halaman index setelah berhasil membuat santri
  }

  protected function getRedirectUrl(): string
  {
    return StudentResource::getUrl('index'); // Redirect ke halaman daftar student
  }


  public function getTitle(): string
  {
    return 'Tambah Santri';
  }

  protected function getCreateFormAction(): Action
  {
    return Actions\CreateAction::make()
      ->label('Save')
      ->submit('create') // agar tidak muncul  pop-up create
      ->color('primary');
  }



  protected function getCreateAnotherFormAction(): Action
  {
    return Action::make('createAnother')
      ->hidden(); //hide bagian "Buat Santri Lainnya"
  }
}
