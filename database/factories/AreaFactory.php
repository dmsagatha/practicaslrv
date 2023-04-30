<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
class AreaFactory extends Factory
{
  public function definition()
  {
    return [
      'name' => $this->faker->unique()->sentence($nbWords = 2), 
    ];
  }
}