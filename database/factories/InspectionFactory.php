<?php

namespace Database\Factories;

use App\Models\Turbine;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inspection>
 */
class InspectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = rand(config('testing.start_date'), intval(config('testing.end_date')));
        return [
            //
            'turbine_id' => Turbine::factory()->create()->id,
            'inspection_date' => Carbon::create($date)->format('Y-m-d H:i:s'),
            'grade' => $this->faker->numberBetween(1, 5)
        ];
    }
}