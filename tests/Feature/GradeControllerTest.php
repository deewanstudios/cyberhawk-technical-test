<?php

namespace Tests\Feature;

use App\Models\Grade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GradeControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $endpoint = 'api/grades';

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function testCreateGrade()
    {
        $validGradeData = Grade::factory()->make()->toArray();
        $response = $this->postJson($this->endpoint, $validGradeData);
        $response->assertStatus(201);
        $response->assertJson(
            [
                'message' => 'New Grade Entity Created Successfully!',
                'data' => $validGradeData
            ]
        );
        $this->assertDatabaseHas('grades', $validGradeData);
    }

    public function testGradeUpdate()
    {
        $grade = Grade::factory()->create();

        $updateGradeData = [
            'value' => $this->faker->numberBetween(1, 5),
            'description' => 'GoodGrade'
        ];

        Grade::where('id', $grade->id)->update($updateGradeData);
        $response = $this->putJson($this->endpoint . '/' . $grade->id, $updateGradeData);
        $updatedGrade =  Grade::find($grade->id);
        $response->assertStatus(200);
        $response->assertExactJson([
            'message' => 'Grade Update Operation Was Successfull!',
            'data' => $updatedGrade->toArray()
        ]);
    }

    public function testGradePatch()
    {
        $grade = Grade::factory()->create();
        $patchData = [
            'value' => $this->faker->numberBetween(1, 5),
            'description' => 'DamagedGrade'
        ];
        Grade::where('id', $grade->id)->update($patchData);
        $response = $this->patchJson($this->endpoint . '/' . $grade['id'], $patchData);
        $response->assertStatus(200);
        $patchedGrade = Grade::findOrFail($grade->id);
        $response->assertExactJson(
            [

                'message' => 'Grade Patch Operation Was Successfull!',
                'data' => $patchedGrade->toArray()
            ]
        );
    }

    public function testGradeDelete()
    {
        $grade = Grade::factory()->create();
        $response = $this->delete($this->endpoint . '/' . $grade->id);
        $response->assertStatus(200);
        $response->assertExactJson([
            'message' => "Grade Delete Operation Was Successfull!",
        ]);
        $this->assertDatabaseMissing('grades', ['id' => $grade->id]);
    }

    public function testgetAll()
    {
        $grades = Grade::factory()->count(5)->create();
        $response = $this->getJson($this->endpoint);
        $response->assertStatus(200);
        $response->assertJsonCount(5);
        $response->assertJson($grades->toArray());
    }

    public function testGetOne()
    {
        $grade = Grade::factory()->create();
        $response =  $this->getJson($this->endpoint . '/' . $grade->id);
        $response->assertStatus(200);
        $response->assertJson($grade->toArray());
    }
}
