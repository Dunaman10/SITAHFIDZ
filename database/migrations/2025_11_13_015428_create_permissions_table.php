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
    Schema::create('permissions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_student')->nullable();
      $table->foreignId('id_parent')->nullable();
      $table->text('reason');
      $table->date('date_out');
      $table->date('date_in');
      $table->string('status')->default('pending');
      $table->string('approved_by')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('permissions');
  }
};
