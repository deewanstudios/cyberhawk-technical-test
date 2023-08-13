<?php

namespace Tests\Feature;

use App\Models\Inspection;
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
        // dump($inspection);
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


}