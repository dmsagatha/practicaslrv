<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('areas', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('areas');
  }
};