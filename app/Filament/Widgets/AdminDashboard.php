<?php

namespace App\Filament\Widgets;

use App\Models\Activity;
use App\Models\Surah;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class adminDashboard extends BaseWidget
{
  protected function getStats(): array

  {
    $CountGuru = Teacher::count();
    $CountSiswa = Student::count();
    $CountKelas = Classes::count();
    $countSurah = Surah::count();
    $countPengguna = User::count();
    $activity = Activity::latest()->first();


    return [
      Stat::make('Total Pengajar', $CountGuru),
      Stat::make('Total Santri', $CountSiswa),
      Stat::make('Total Kelas', $CountKelas),
      Stat::make('Total Surat', $countSurah),
      Stat::make('Total Pengguna', $countPengguna),
      Stat::make('Kegiatan Pondok Pesantren', '')
        ->icon('heroicon-o-calendar-days')
        ->description($activity?->activity_name ?? 'Belum ada kegiatan'),
    ];
  }
}
