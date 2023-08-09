<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Component>
 */
class ComponentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $min = config('testing.min_value');
        $max = config('testing.max_value');

        return [
            //
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween($min, $max)
        ];
    }
}