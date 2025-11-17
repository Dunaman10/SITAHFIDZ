<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateDailyAttendance extends Command
{
  protected $signature = 'app:generate-daily-attendance';
  protected $description = 'Generate daily attendance records for all students';


  public function handle()
  {
    $today = now()->toDateString();

    // jika sudah ada record untuk hari ini, hentikan
    if (Attendance::where('date', $today)->exists()) {
      $this->info('Attendance for today already generated.');
      return 0;
    }

    $students = Student::with(['class', 'user'])->get();

    // bulk-insert array untuk performa
    $rows = [];
    $now = now();
    foreach ($students as $s) {
      $rows[] = [
        'id_student' => $s->id,
        'id_class'   => $s->class_id ?? null,
        'date'       => $today,
        'status'     => 'belum_absen',
        'created_at' => $now,
        'updated_at' => $now,
      ];
    }

    if (!empty($rows)) {
      DB::table('attendances')->insert($rows);
      $this->info('Daily attendance generated for ' . count($rows) . ' students.');
    } else {
      $this->info('No students found to generate attendance.');
    }

    return 0;
  }
}
