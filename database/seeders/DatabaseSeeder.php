<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    Area::factory(5)->create();
    // \App\Models\User::factory(100)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);
    $areas = Area::pluck('id')->all();
    
    for ($i = 0; $i < 500; $i++) {
      User::create([
        'first_name'        => fake()->firstName(),
        'last_name'         => fake()->lastName(),
        'email'             => fake()->unique()->safeEmail(),
        // 'image'             => 'noavatar.png',
        'email_verified_at' => now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token'    => Str::random(10),
        'area_id'           => fake()->randomElement($areas),
      ]);
    }
  }
}