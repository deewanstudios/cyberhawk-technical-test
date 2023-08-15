<?php

namespace Tests\Feature;

use App\Models\Inspection;
use App\Models\Turbine;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InspectionControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    protected $endpoint = "api/inspections";

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function testCreateInspection()
    {
        $inspection = Inspection::factory()->create()->toArray();
        $response = $this->postJson($this->endpoint, $inspection);
        $response->assertStatus(201);

        $response->assertJson([
            'message' => 'New Inspection Entity Created Successfully!',
            'data' => [

                'turbine_id' => $inspection['turbine_id'],
                'inspection_date' => $inspection['inspection_date'],
                'grade' => $inspection['grade']
            ]
        ]);
        $this->assertDatabaseHas('inspections', $inspection);
    }

    public function testUpdateInspection()
    {
        $inspection = Inspection::factory()->create();
        $updateInspection = [
            'turbine_id' => $inspection['turbine_id'],
            'inspection_date' => Carbon::create('now')->toDateTime()->format('Y-m-d H:i:s'),
            'grade' => 3
        ];

        Inspection::where('id', $inspection->id)->update($updateInspection);
        $response = $this->putJson($this->endpoint . '/' . $inspection->id, $updateInspection);
        $response->assertStatus(200);
        $updatedInspection = Inspection::find($inspection->id);
        $response->assertExactJson([
            'message' => 'Inspection Update Operation Was Successfull!',
            'data' => $updatedInspection->toArray()
        ]);
    }


    public function testInspectionPatch()
    {
        $inspection = Inspection::factory()->create();
        $patchInspection = [
            'grade' => 4
        ];
        Inspection::where('id', $inspection->id)->update($patchInspection);
        $response = $this->patchJson($this->endpoint . '/' . $inspection->id, $patchInspection);
        $response->assertStatus(200);
        $patchedInspection = Inspection::findOrFail($inspection->id);
        $response->assertExactJson([

            'message' => 'Inspection Patch Operation Was Successfull!',
            'data' => $patchedInspection->toArray()
        ]);

        $this->assertEquals($patchInspection['grade'], $patchedInspection->grade);
    }

    public function testInspectionDelete()
    {
        $inspection = Inspection::factory()->create();
        $response = $this->deleteJson($this->endpoint . '/' . $inspection->id);
        $response->assertStatus(200);
        $response->assertExactJson([
            'message' => 'Inspection Delete Operation Was Successfull!',
        ]);
        $this->assertDatabaseMissing('inspections', ['id' => $inspection->id]);
    }

    public function testGetAll()
    {
        $inspections = Inspection::factory()->count(5)->create();
        $response = $this->getJson($this->endpoint);
        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function testGetInspectionWithTurbines()
    {

        $turbineA = Turbine::factory()->create();
        $turbineB = Turbine::factory()->create();

        $inspectionA = Inspection::factory()->create(['turbine_id' => $turbineA->id]);
        $inspectionB = Inspection::factory()->create(['turbine_id' => $turbineB->id]);

        $response = $this->getJson($this->endpoint);
        $response->assertStatus(200);
        $response->assertJsonCount(2); 
    }

}