<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeUserWithRole extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'make:user-with-role';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Buat user baru dengan name, email, password, dan role';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $name = $this->ask('Name');
    $email = $this->ask('Email');
    $password = $this->secret('Password');
    $role = $this->ask('Role');

    // Validasi email sudah ada belum
    if (User::where('email', $email)->exists()) {
      $this->error('User dengan email ini sudah ada!');
      return 1;
    }

    User::create([
      'name' => $name,
      'email' => $email,
      'password' => Hash::make($password),
      'role' => $role,
    ]);

    $this->info("User berhasil dibuat dengan role '$role'.");
    return 0;
  }
}
