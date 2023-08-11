<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\Grade;
use App\Models\Turbine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create grades with values from 1 to 5
        for ($value = 1; $value <= 5; $value++) {
            Grade::create([
                'value' => $value,
                'description' => "Grade $value description",
            ]);
        }

        // Create turbines
        $turbines = Turbine::factory(10)->create();

        // Create components and associate with turbines
        foreach ($turbines as $turbine) {
            $components = Component::factory(2)->create();
            $grades = Grade::all()->random(2); // Randomly select two grades

            foreach ($components as $key => $component) {
                $turbine->components()->attach($component, ['grade_id' => $grades[$key]->id]);
            }
        }

    }
}