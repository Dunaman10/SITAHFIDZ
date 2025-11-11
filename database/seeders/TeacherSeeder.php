<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $data = [];

    // asumsi user id 1 - 10 adalah guru
    for ($i = 2; $i <= 6; $i++) {
      $data[] = [
        'id_users'   => $i,
      ];
    }

    DB::table('teachers')->insert($data);
  }
}
