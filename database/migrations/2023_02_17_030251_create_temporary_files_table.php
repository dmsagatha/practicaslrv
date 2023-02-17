<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  public function up()
  {
    Schema::create('temporary_files', function (Blueprint $table) {
      $table->id();
      $table->string('folder');
      $table->string('file');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('temporary_files');
  }
};