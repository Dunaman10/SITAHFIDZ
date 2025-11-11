<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemorizeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $insertData = [];

    for ($i = 1; $i <= 100; $i++) {
      $insertData[] = [
        'id_surah'   => ($i % 10) + 1,  // biar muter dari 1-10
        'id_student' => ($i % 20) + 1, // misal ada 20 student
        'id_teacher' => ($i % 5) + 1,  // misal ada 5 teacher
        'from'       => rand(1, 50),
        'to'         => rand(51, 100),
        'audio'      => null,
        'complete'   => rand(0, 1),
        'created_at' => date('Y-m-d H:i:s'), // ga pake carbon
        'updated_at' => date('Y-m-d H:i:s'),
      ];
    }

    DB::table('memorizes')->insert($insertData);
  }
}
