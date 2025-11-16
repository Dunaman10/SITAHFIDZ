<?php

namespace App\Console;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  protected function schedule(Schedule $schedule): void
  {
    // place your schedules here
    $schedule->call(function () {
      $students = Student::all();
      $today = now()->format('Y-m-d');

      foreach ($students as $student) {
        Attendance::firstOrCreate(
          [
            'id_student' => $student->id,
            'date' => $today,
          ],
          [
            'id_class' => $student->class_id,
            'id_parent' => $student->parent,
            'status' => null,
          ]
        );
      }
    })->dailyAt('00:00');
  }

  protected function commands(): void
  {
    $this->load(__DIR__ . '/Commands');
    require base_path('routes/console.php');
  }
}
