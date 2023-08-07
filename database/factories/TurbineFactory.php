<?php

namespace Database\Factories;

use App\Models\Farm;
use Carbon\Carbon;
use App\Models\Turbine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Turbine>
 */
class TurbineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $enumValues = config('testing.farm_enum_values');
        $startDate = config('testing.start_date');
        $endDate = intval(config('testing.end_date'));
        $date = Carbon::create(rand($startDate, $endDate))->toDateString();
        $coordinates = json_encode(['latitude' => $this->faker->latitude, 'longitude' => $this->faker->longitude]);
        $farmId = Farm::factory()->create()->id;


        return [
            //
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'location' => $coordinates,
            'farm_id' => $farmId,
            'install_date' => $date,
            'status' => $enumValues[array_rand($enumValues)]
        ];
    }
}
