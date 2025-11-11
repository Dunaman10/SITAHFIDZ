<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $data = [];

    for ($i = 1; $i <= 10; $i++) {
      $data[] = [
        'class_name' => 'Kelas ' . $i,
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('classes')->insert($data);
  }
}
