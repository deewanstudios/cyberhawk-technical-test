<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\Grade;
use App\Models\Inspection;
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
        $gradeDescriptions = [
            'Excellent',
            'Very Good',
            'Good',
            'Fair',
            'Damaged',
        ];

        // Create grades with custom descriptions
        foreach ($gradeDescriptions as $value => $description) {
            Grade::create([
                'value' => $value + 1,
                'description' => $description,
            ]);
        }

        // Create components
        $componentNames = [
            'Rotor Blades',
            'Rotor Hub',
            'Gearbox',
            'Generator',
            'Nacelle',
            'Wind Vane',
            'Brakes',
            'Tower',
        ];

        $components = [];
        foreach ($componentNames as $name) {
            $components[$name] = Component::create(['name' => $name]);
        }

        // Create turbines
        $turbines = Turbine::factory(10)->create();

        // Create inspections for each turbine
        foreach ($turbines as $turbine) {
            foreach ($components as $component) {
                $turbine->components()->attach($component, [
                    'grade_id' => Grade::all()->random()->id,
                ]);
            }

            Inspection::factory(3)->create([
                'turbine_id' => $turbine->id,
            ]);
        }

    }
}