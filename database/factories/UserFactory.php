<?php

namespace Database\Factories;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
  public function definition()
  {
    return [
      'first_name'        => fake()->firstName(),
      'last_name'         => fake()->lastName(),
      'email'             => fake()->unique()->safeEmail(),
      'email_verified_at' => now(),
      'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
      'remember_token' => Str::random(10),
      'area_id'           => Area::all()->random()->id,
    ];
  }
  
  public function unverified()
  {
    return $this->state(fn(array $attributes) => [
      'email_verified_at' => null,
    ]);
  }
}