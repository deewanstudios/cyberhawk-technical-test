<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $launchedDate = Carbon::today()->toDateString();
        $enumValues = config('testing.farm_enum_values');
        $coordinates = json_encode(['latitude' => $this->faker->latitude, 'longitude' => $this->faker->longitude]);

        return [
            //
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'coordinates' => $coordinates,
            'capacity' => $this->faker->numberBetween($minValue, $maxValue),
            'launched_date' => $launchedDate,
            'status' => $enumValues[array_rand($enumValues)]
        ];
    }
}
