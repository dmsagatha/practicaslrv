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
      'name' => $this->faker->unique()->sentence($nbWords = 3),   //$this->faker->text($maxNbChars = 6) o $this->faker->sentence(3)
      'acronym' => $this->faker->unique()->word,
      'description' => $this->faker->sentence($nbWords = 10)    //$this->faker->tex
    ];
  }
}