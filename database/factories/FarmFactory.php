<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Farm>
 */
class FarmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $minValue = config('testing.min_value');
        $maxValue = config('testing.max_value');
        $startDate = config('testing.start_date');
        $endDate = config('testing.end_date');
        $launchedDate = $this->faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d');
        $enumValues = config('testing.farm_enum_values');
        $coordinates = json_encode(['latitude' => $this->faker->latitude, 'longitude' => $this->faker->longitude]);
        return [
            //
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'coordinates' => $coordinates,
            // 'capacity' => $this->faker->numberBetween($minValue, $maxValue),
            'capacity' => $this->faker->randomDigit(1, 100),
            'launched_date' => $launchedDate,
            'status' => $this->faker->randomElement($enumValues)
        ];
    }
}
