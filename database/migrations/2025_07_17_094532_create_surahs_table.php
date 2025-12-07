<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('surah', function (Blueprint $table) {
      $table->id();
      $table->integer('juz');
      $table->text('surah_name');
      $table->integer('ayat');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('surah');
  }
};
