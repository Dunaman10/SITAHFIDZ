<?php

namespace App\Filament\Widgets;

use App\Models\Surah;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
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

        return [

            Stat::make('Total Ustad', $CountGuru ),
            Stat::make('Total Siswa', $CountSiswa),
            Stat::make('Total Kelas', $CountKelas),
            Stat::make('Total Surat', $countSurah),
            Stat::make('Setoran Hafalan', 'Baik')// belum ada data
                ->chart([0,1,2,7,9]) // data dummy
                ->color('success'), 
               
               
            
        ];
    }
}
