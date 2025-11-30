<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Filament\Actions;
use App\Services\FonnteService;
use App\Models\User;
use Carbon\Carbon;

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

  // Kalau mau, afterCreate cukup buat notif saja
  protected function afterCreate(): void
  {
    Notification::make()
      ->title('Berhasil')
      ->body('Berhasil menambahkan kegiatan baru')
      ->success()
      ->send();
  }

  // 🔥 Tombol di bawah form (Create, Create & Kirim WA, Cancel)
  protected function getFormActions(): array
  {
    return [
      $this->getCreateFormAction(),                // tombol Create biasa
      $this->getCreateAnotherFormAction(),         // tombol Create & create another (kalau mau)
      $this->getCancelFormAction(),                // tombol Cancel

      Actions\Action::make('createAndSendWa')
        ->label('Create & Kirim WA')
        ->icon('heroicon-o-paper-airplane')
        ->color('success')
        ->requiresConfirmation()
        ->action(function (FonnteService $fonnte) {

          // 1. Simpan kegiatan dulu
          $this->create();          // ini method bawaan CreateRecord
          $activity = $this->record;

          // 2. Ambil semua wali yang punya nomor WA
          $wali = User::where('role_id', 3)
            ->whereNotNull('phone')
            ->get();

          if ($wali->isEmpty()) {
            Notification::make()
              ->title('Kegiatan dibuat, tapi tidak ada wali yang memiliki nomor WhatsApp.')
              ->warning()
              ->send();

            return;
          }

          // 3. Format tanggal
          $tanggal = Carbon::parse($activity->activity_date)
            ->translatedFormat('d F Y');

          // 4. Kirim WA
          $sent = 0;
          foreach ($wali as $w) {
            $message = "السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ

Yth. Bapak/Ibu Wali Santri {$w->name},

Dengan hormat, kami informasikan bahwa Pondok Pesantren akan menyelenggarakan kegiatan sebagai berikut:

📌 *Kegiatan* : {$activity->activity_name}
📅 *Tanggal*  : {$tanggal}
📝 *Deskripsi*: {$activity->description}
🔔 *Keterangan*: Wali Santri {$activity->keterangan}

Kami memohon kesediaan Bapak/Ibu untuk memperhatikan informasi tersebut dan mendukung kelancaran kegiatan santri.

Demikian pemberitahuan ini kami sampaikan. Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.

وَالسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ";

            if ($fonnte->send($w->phone, $message)) {
              $sent++;
            }
          }

          Notification::make()
            ->title("Kegiatan dibuat dan WA terkirim ke {$sent} wali santri.")
            ->success()
            ->send();

          // 5. Balik ke index
          $this->redirect(ActivityResource::getUrl('index'));
        }),
    ];
  }
}
