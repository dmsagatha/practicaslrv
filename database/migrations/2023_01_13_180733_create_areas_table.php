<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  public function up()
  {
    Schema::create('areas', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('acronym')->unique();
      $table->mediumText('description');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('areas');
  }
};