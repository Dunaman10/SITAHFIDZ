<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use App\Models\Teacher;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class CreateTeacher extends CreateRecord
{
  protected static string $resource = TeacherResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }

  public function getTitle(): string
  {
    return 'Tambah Guru Baru';
  }

  protected function handleRecordCreation(array $data): Teacher
  {
    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
      'role_id' => 2
    ]);

    return Teacher::create([
      'id_users' => $user->id
    ]);
  }

  protected function afterCreate(): void
  {
    Notification::make()
      ->title('Berhasil')
      ->body('Berhasil menambahkan guru baru')
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
