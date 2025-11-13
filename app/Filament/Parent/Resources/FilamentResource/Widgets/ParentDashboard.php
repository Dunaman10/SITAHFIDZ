<?php

namespace App\Filament\Parent\Widgets;

use App\Models\Activity;
use App\Models\Memorize;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ParentDashboard extends BaseWidget
{
  protected function getStats(): array
  {
    $user = Filament::auth()->user();
    $activity = Activity::latest()->first();


    // Ambil progres hafalan TERBARU milik anak-anak user (orang tua) ini
    $latest = Memorize::with(['student:id,student_name,parent', 'surah:id,surah_name'])
      ->whereHas('student', fn($q) => $q->where('parent', $user->id))
      ->latest('created_at')
      ->first();

    if (! $latest) {
      return [
        Stat::make('Progress Terbaru', '—')
          ->description('Belum ada progres hafalan anak.')
          ->color('gray'),
        Stat::make('Kegiatan Pondok Pesantren', '')
          ->icon('heroicon-o-calendar-days')
          ->description($activity?->activity_name ?? 'Belum ada kegiatan'),
      ];
    }

    $title = 'Progress Terbaru - ' . ($latest->student->student_name ?? '—');
    $value = $latest->complete ? 'Selesai' : 'Proses';
    $desc  = 'Surah ' . ($latest->surah->surah_name ?? '—') . ' ' . ($latest->from ?? '-') . ' - ' . ($latest->to ?? '-');

    return [
      Stat::make($title, $value)
        ->description($desc)
        ->color($latest->complete ? 'success' : 'warning'),

    ];
  }
}
