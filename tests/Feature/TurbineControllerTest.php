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

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function testCreateTurbine()
    {
        // $this->withoutExceptionHandling();
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

    public function testTurbinePatch()
    {
        $turbine = Turbine::factory()->create();
        $patchData = [
            'name' => 'Turbine Name Patch',
            'description' => 'Turbine Description Patch'
        ];
        Turbine::where('id', $turbine->id)->update($patchData);
        $response = $this->patchJson($this->endpoint . '/' . $turbine['id'], $patchData);
        $response->assertStatus(200);
        $patchedTurbine = Turbine::findOrFail($turbine->id);
        $response->assertJson(
            [

                'message' => 'Turbine Patch Operation Was Successfull!',
                'data' => $patchedTurbine->toArray()
            ]
        );
    }
}
