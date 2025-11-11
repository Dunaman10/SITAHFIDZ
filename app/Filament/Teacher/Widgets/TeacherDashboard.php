<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Student;
use App\Models\ClassTeacher;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class TeacherDashboard extends BaseWidget
{
  protected function getStats(): array
  {
    $user = Auth::user();
    $teacher = $user?->teacher; // Pakai optional chaining (?->) biar nggak error kalau null

    $countClasses = $teacher ? $teacher->classes()->count() : 0;
    $countStudents = $teacher ? $teacher->students()->count() : 0;

    return [
      Stat::make('Jumlah Santri Anda', $countStudents)
        ->icon('heroicon-o-user-group'),
      Stat::make('Jumlah Kelas Anda', $countClasses)
        ->icon('heroicon-o-building-office'),
    ];
  }
}
