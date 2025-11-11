<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $users = [];

    // 1 Admin
    $users[] = [
      'name' => 'Admin',
      'email' => 'admin@example.com',
      'email_verified_at' => now(),
      'password' => Hash::make('password'),
      'role_id' => 1,
      'remember_token' => Str::random(10),
      'created_at' => now(),
      'updated_at' => now(),
    ];

    // 20 Guru -> role_id = 2
    for ($i = 1; $i <= 20; $i++) {
      $users[] = [
        'name' => "Guru $i",
        'email' => "guru$i@example.com",
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'role_id' => 2,
        'remember_token' => Str::random(10),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    // 200 Orang Tua -> role_id = 3
    for ($i = 1; $i <= 200; $i++) {
      $users[] = [
        'name' => "Orang Tua $i",
        'email' => "orangtua$i@example.com",
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'role_id' => 3,
        'remember_token' => Str::random(10),
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    DB::table('users')->insert($users);
  }
}
