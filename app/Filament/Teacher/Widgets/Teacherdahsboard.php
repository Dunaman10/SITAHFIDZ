<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Classes;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class Teacherdahsboard extends BaseWidget
{
    protected function getStats(): array
    {
        $countStudents = Student::count();
        $countClasses = Classes::count();
        return [
            stat::make('Jumlah Santri', $countStudents),
            stat::make('Jumlah Kelas', $countClasses),
                
                     //
        ];
    }
}
