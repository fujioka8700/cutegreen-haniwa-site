<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'id' => Str::random(32),
          'user_id' => fn() => User::factory()->create()->id,
          'filename' => Str::random(32) . '.jpg',
          'created_at' => $this->faker->datetime(),
          'updated_at' => $this->faker->datetime()
        ];
    }
}
