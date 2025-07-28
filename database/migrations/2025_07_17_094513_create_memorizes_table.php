<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('memorizes', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_surah');
      $table->foreignId('id_student');
      $table->foreignId('id_teacher');
      $table->integer('from');
      $table->integer('to');
      $table->string('audio');
      $table->tinyInteger('complete');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('memorizes');
  }
};
