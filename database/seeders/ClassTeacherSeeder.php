<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTeacherSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $data = [];

    for ($i = 1; $i <= 10; $i++) {
      $data[] = [
        'id_class'    => $i,  // kelas 1-10
        'id_teacher'  => $i,  // guru 1-10
        'created_at'  => now(),
        'updated_at'  => now(),
      ];
    }

    DB::table('class_teacher')->insert($data);
  }
}
