<?php

namespace Tests\Unit;

use App\Models\Turbine;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TurbineTest extends TestCase
{
    use DatabaseTransactions;

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

    }
}