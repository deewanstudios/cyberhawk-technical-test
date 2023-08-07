<?php

namespace Tests\Feature;

use App\Models\Turbine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Requests\TurbineStore;

class TurbineControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $endpoint = 'api/turbines';

    public function testCreateTurbine()
    {
        $this->withoutExceptionHandling();
        $validTurbineData = Turbine::factory()->make()->toArray();
        $response = $this->postJson($this->endpoint, $validTurbineData);
        $response->assertStatus(201);
        $response->assertJson(
            [
                'message' => 'New Turbine Entity Created Successfully!',
                'data' => $validTurbineData
            ]
        );
        $this->assertDatabaseHas('turbines', $validTurbineData);
    }
}
