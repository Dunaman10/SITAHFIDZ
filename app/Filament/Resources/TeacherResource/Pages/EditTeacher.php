<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EditTeacher extends EditRecord
{
  protected static string $resource = TeacherResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return TeacherResource::getUrl('index');
  }

  /**
   * Saat membuka halaman edit → isi form dengan data relasi user
   */
  protected function mutateFormDataBeforeFill(array $data): array
  {
    $data['name'] = $this->record->user->name;
    $data['email'] = $this->record->user->email;

    // password JANGAN diisi, tetap kosong
    $data['password'] = '';

    return $data;
  }

  /**
   * Simpan perubahan ke tabel user
   */
  protected function handleRecordUpdate(Model $record, array $data): Model
  {
    // update name & email
    $record->user->update([
      'name' => $data['name'],
      'email' => $data['email'],
    ]);

    // kalau password diisi, update juga
    if (!empty($data['password'])) {
      $record->user->update([
        'password' => Hash::make($data['password']),
      ]);
    }

    return $record;
  }
}
