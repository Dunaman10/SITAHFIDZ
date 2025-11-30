<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
  public function send(string $number, string $message): bool
  {
    try {
      $response = Http::withHeaders([
        'Authorization' => config('services.fonnte.token'),
      ])->asForm()->post(config('services.fonnte.url'), [
        'target'  => $number,
        'message' => $message,
      ]);

      return $response->successful();
    } catch (\Throwable $e) {

      Log::error('Fonnte Error', [
        'msg' => $e->getMessage()
      ]);

      return false;
    }
  }
}
