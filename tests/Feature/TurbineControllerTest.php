<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Farm;
use App\Models\Turbine;
use App\Http\Requests\TurbineStore;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    public function testTurbineUpdate()
    {
        $turbine = Turbine::factory()->create();
        $turbineEnums = config('testing.turbine_enums');
        $startDate = config('testing.start_date');
        $endDate = intval(config('testing.end_date'));
        $date = Carbon::create(rand($startDate, $endDate))->toDateString();
        $farmId = Farm::factory()->create()->id;

        $updateTurbineData = [
            'name' => 'Updated Turbine Name',
            'description' => 'Updated Turbine Description',
            'location' => 'Updated Turbine Location',
            'farm_id' => $farmId,
            'install_date' => $date,
            'status' => $turbineEnums[array_rand($turbineEnums)]
        ];

        Turbine::where('id', $turbine->id)->update($updateTurbineData);
        $response = $this->putJson($this->endpoint . '/' . $turbine->id, $updateTurbineData);
        $updatedTurbine =  Turbine::find($turbine->id);
        $response->assertStatus(200);
        $response->assertExactJson([
            'message' => 'Turbine Update Operation Was Successfull!',
            'data' => $updatedTurbine->toArray()
        ]);
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
        $response->assertExactJson(
            [

                'message' => 'Turbine Patch Operation Was Successfull!',
                'data' => $patchedTurbine->toArray()
            ]
        );
    }

    public function testTurbineDelete()
    {
        $turbine = Turbine::factory()->create();
        $response = $this->delete($this->endpoint . '/' . $turbine->id);
        $response->assertStatus(200);
        $response->assertExactJson([
            'message' => "Turbine Delete Operation Was Successfull!",
        ]);
        $this->assertDatabaseMissing('turbines', ['id' => $turbine->id]);
    }

    /*  public function test{

    } */
}
