<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Classes;
use App\Models\Student;
use App\Models\ClassTeacher;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class Teacherdahsboard extends BaseWidget
{
  protected function getStats(): array
  {
    $teacher = Auth::user();

    // Ambil semua class_id dari class_teacher berdasarkan id_teacher
    $classIds = ClassTeacher::where('id_teacher', $teacher->id)->pluck('id_class');

    // Hitung santri yang berada di kelas-kelas itu
    $countStudents = Student::whereIn('class_id', $classIds)->count();

    // Hitung jumlah kelas yang dia pegang
    $countClasses = $classIds->count();
    // dd($classIds, $countStudents, $countClasses);


    return [
      Stat::make('Jumlah Santri Anda', $countStudents),
      Stat::make('Jumlah Kelas Anda', $countClasses),
    ];
  }
}
