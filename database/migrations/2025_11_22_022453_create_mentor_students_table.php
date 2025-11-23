<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('mentor_students', function (Blueprint $table) {
      $table->id();

      $table->foreignId('id_teacher')
        ->constrained('teachers')
        ->cascadeOnDelete();

      $table->foreignId('id_student')
        ->constrained('students')
        ->cascadeOnDelete();

      $table->timestamps();

      // untuk mencegah 1 guru membina santri yang sama dua kali
      $table->unique(['id_teacher', 'id_student']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('mentor_students');
  }
};
