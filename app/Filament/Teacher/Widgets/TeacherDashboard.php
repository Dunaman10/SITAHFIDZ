<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Activity;
use App\Models\Classes;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class TeacherDashboard extends BaseWidget
{
  protected function getStats(): array
  {
    // $user = Auth::user();
    // $teacher = $user?->teacher; // Pakai optional chaining (?->) biar nggak error kalau null
    $activity = Activity::latest()->first();

    // $countClasses = $teacher ? $teacher->classes()->count() : 0;
    // $countStudents = $teacher ? $teacher->students()->count() : 0;
    $countClasses = Classes::all()->count();
    $countStudents = Student::all()->count();


    return [
      Stat::make('Jumlah Santri', $countStudents)
        ->icon('heroicon-o-user-group'),
      Stat::make('Jumlah Kelas', $countClasses)
        ->icon('heroicon-o-building-office'),
      Stat::make('Kegiatan Pondok Pesantren', '')
        ->icon('heroicon-o-calendar-days')
        ->description($activity?->activity_name ?? 'Belum ada kegiatan'),
    ];
  }
}
