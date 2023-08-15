<?php

namespace Tests\Unit;

use App\Models\Component;
use App\Models\Grade;
use Tests\TestCase;
use App\Models\Turbine;
use App\Models\TurbineComponent;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;

class TurbineTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * Summary of testCreateTurbine
     * @return void
     */
    public function testCreateTurbine()
    {
        $turbine = Turbine::factory()->create();
        $this->assertNotEmpty($turbine->id);
        $this->assertNotEmpty($turbine->name);
        $this->assertDatabaseHas('turbines', ['name' => $turbine->name]);
        $this->assertDatabaseHas('turbines', ['description' => $turbine->description]);
        $this->assertDatabaseHas('turbines', ['location' => $turbine->location]);
        $this->assertDatabaseHas('turbines', ['farm_id' => $turbine->farm_id]);
        $this->assertDatabaseHas('turbines', ['install_date' => $turbine->install_date]);
        $this->assertDatabaseHas('turbines', $turbine->toArray());
    }

    public function testGetAllTurbines()
    {
        Turbine::factory()->count(5)->create();
        $turbines = Turbine::all();
        $this->assertCount(5, $turbines);
        foreach ($turbines as $turbine) {
            $this->assertInstanceOf(Turbine::class, $turbine);
            $this->assertModelExists($turbine);
            $this->assertEquals($turbines->find($turbine->id)->name, $turbine->name);
        }
    }

    public function testGetATurbine()
    {
        $turbine = Turbine::factory()->create();
        $retrieveTurbine = Turbine::find($turbine->id);
        $this->assertEquals($turbine->location, $retrieveTurbine->location);
    }

    public function testUpdateTurbine()
    {
        $turbine = Turbine::factory()->create();
        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
        ];
        Turbine::where('id', $turbine->id)->update($data);
        $updatedTurbine = Turbine::find($turbine->id);
        foreach ($data as $key => $value) {
            $this->assertArrayHasKey($key, $updatedTurbine);
        }
    }

    public function testPatchTurbine()
    {
        $turbine = Turbine::factory()->create();
        $patchData = [
            'install_date' => Carbon::create("-18 years")->format('Y-m-d'),
            'status' => 'Retired'
        ];
        $turbine->fill($patchData);
        $turbine->save();
        $this->assertEquals($patchData['install_date'], $turbine->install_date);
        $this->assertEquals($patchData['install_date'], $turbine->install_date);
    }


    public function testDeleteTurbine()
    {
        $turbine = Turbine::factory()->create();
        Turbine::destroy($turbine->id);
        $this->assertDatabaseMissing('turbines', ['id' => $turbine->id]);
    }


    public function testTurbineComponents()
    {
        // Create a turbine instance with associated components
        $turbine = Turbine::factory()
            ->has(TurbineComponent::factory()->count(2)) // Create 2 associated components
            ->create();

        // Retrieve the turbine components through relationship
        $turbineComponents = $turbine->turbineComponents;

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $turbineComponents);
        $this->assertCount(2, $turbineComponents);

        foreach ($turbineComponents as $turbineComponent) {
            $this->assertInstanceOf(TurbineComponent::class, $turbineComponent);
            $this->assertInstanceOf(Component::class, $turbineComponent->component);
            $this->assertInstanceOf(Grade::class, $turbineComponent->grade);
            $this->assertNotEmpty($turbineComponent->component->name);
            $this->assertNotEmpty($turbineComponent->grade->value);
        }
    }



}