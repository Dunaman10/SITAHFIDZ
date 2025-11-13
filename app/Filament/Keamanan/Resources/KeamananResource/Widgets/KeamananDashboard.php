<?php

namespace App\Filament\Keamanan\Resources\KeamananResource\Widgets;

use App\Models\Activity;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KeamananDashboard extends BaseWidget
{
  protected function getStats(): array
  {

    $activity = Activity::latest()->first();

    return [
      Stat::make('Kegiatan Pondok Pesantren', '')
        ->icon('heroicon-o-calendar-days')
        ->description($activity?->activity_name ?? 'Belum ada kegiatan'),
    ];
  }
}
