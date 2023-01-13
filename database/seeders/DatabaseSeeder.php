<?php

namespace Database\Seeders;

use App\Models\{Area, User};
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run()
  {
    User::query()->delete();
    Area::query()->delete();

    DB::table('areas')->insert([
      ['name' => 'Area A', 'acronym' => 'area_a', 'description' => 'Descripción A'],
      ['name' => 'Area B', 'acronym' => 'area_b', 'description' => 'Descripción B'],
      ['name' => 'Area C', 'acronym' => 'area_c', 'description' => 'Descripción C'],
      ['name' => 'Area D', 'acronym' => 'area_d', 'description' => 'Descripción D'],
      ['name' => 'Area E', 'acronym' => 'area_e', 'description' => 'Descripción E'],
    ]);
    Area::factory()->count(2)->create();

    \App\Models\User::factory()->count(5)->create();
    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);
  }
}