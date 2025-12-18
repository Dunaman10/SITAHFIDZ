<?php

namespace App\Console\Commands;

use App\Models\Memorize;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanOldHafalanAudio extends Command
{

  protected $signature = 'app:clean-old-hafalan-audio';
  protected $description = 'Delete memorize audio older than 7 days';

  public function handle()
  {
    $limit = Carbon::now()->subMonths(6);

    $records = Memorize::where('created_at', '<', $limit)
      ->whereNotNull('audio')
      ->get();

    foreach ($records as $row) {
      if (Storage::disk('public')->exists($row->audio)) {
        Storage::disk('public')->delete($row->audio);
      }

      // Clear kolom audio agar tidak referensi ke file yang sudah hilang
      $row->update(['audio' => null]);
    }

    $this->info('Audio hafalan lama berhasil dibersihkan.');
  }
}
