<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Ambil semua parent (user dengan role_id = 3)
    $parents = DB::table('users')->where('role_id', 3)->get();

    // Jika tidak ada parent, hentikan
    if ($parents->isEmpty()) {
      $this->command->warn('⚠️ Tidak ada user dengan role_id = 3 (parent)');
      return;
    }

    // Buat array students
    $students = [];
    foreach ($parents as $index => $parent) {
      $students[] = [
        'student_name' => 'Siswa ' . ($index + 1),
        'parent' => $parent->id,
        'class_id' => rand(1, 3), // contoh class_id acak
        'profile' => 'default.jpg',
        'tanggal_lahir' => Carbon::now()->subYears(rand(10, 17))->subDays(rand(0, 365)),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    // Masukkan ke tabel students
    DB::table('students')->insert($students);

    $this->command->info('✅ StudentSeeder berhasil dijalankan! (' . count($students) . ' siswa ditambahkan)');
  }
}
