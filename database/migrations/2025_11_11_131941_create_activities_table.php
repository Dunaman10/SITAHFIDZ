<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('activities', function (Blueprint $table) {
      $table->id();
      $table->text('activity_name');
      $table->text('description');
      $table->date('activity_date');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('activities');
  }
};
