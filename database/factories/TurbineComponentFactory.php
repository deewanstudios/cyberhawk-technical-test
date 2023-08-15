<?php

namespace Database\Factories;

use App\Models\Component;
use App\Models\Grade;
use App\Models\Turbine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TurbineComponent>
 */
class TurbineComponentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        // $turbineId = Turbine::factory()->create()->id;
        return [
            //
            'turbine_id' => Turbine::factory()->create()->id,
            'component_id' => Component::factory()->create()->id,
            'grade_id' => Grade::factory()->create()->id,
        ];
    }
}