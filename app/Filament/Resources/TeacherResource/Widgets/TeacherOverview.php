<?php

namespace App\Filament\Resources\TeacherResource\Widgets;

use App\Filament\Resources\TeacherResource;
use App\Models\Teacher;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TeacherOverview extends BaseWidget
{
  protected function getStats(): array
  {
    return [
      Stat::make('Total Guru', User::where('role_id', 2)->count()),
    ];
  }
}
