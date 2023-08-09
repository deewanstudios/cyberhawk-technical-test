<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Component;

class ComponentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $endpoint = 'api/components';
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function testCreateComponent()
    {
        $validComponentData = Component::factory()->make()->toArray();
        $response = $this->postJson($this->endpoint, $validComponentData);
        $response->assertStatus(201);
        $response->assertJson(
            [
                'message' => 'New Component Entity Created Successfully!',
                'data' => $validComponentData
            ]
        );
        $this->assertDatabaseHas('Components', $validComponentData);
    }

    public function testComponentUpdate()
    {
        $component = Component::factory()->create();
        $min = config('testing.min_value');
        $max = config('testing.max_value');
        $updateComponentData = [
            'name' => 'Updated Component Name',
            'description' => 'Updated Component Description',
            'quantity' => $this->faker->numberBetween($min, $max)
        ];

        Component::where('id', $component->id)->update($updateComponentData);
        $response = $this->putJson($this->endpoint . '/' . $component->id, $updateComponentData);
        $updatedComponent = Component::find($component->id);
        $response->assertStatus(200);
        $response->assertExactJson([
            'message' => 'Component Update Operation Was Successfull!',
            'data' => $updatedComponent->toArray()
        ]);
    }

    public function testComponentPatch()
    {
        $component = Component::factory()->create();
        $patchData = [
            'name' => 'Component Name Patch',
            'description' => 'Component Description Patch'
        ];
        Component::where('id', $component->id)->update($patchData);
        $response = $this->patchJson($this->endpoint . '/' . $component['id'], $patchData);
        $response->assertStatus(200);
        $patchedComponent = Component::findOrFail($component->id);
        $response->assertExactJson(
            [

                'message' => 'Component Patch Operation Was Successfull!',
                'data' => $patchedComponent->toArray()
            ]
        );
    }

    public function testComponentDelete()
    {
        $component = Component::factory()->create();
        $response = $this->delete($this->endpoint . '/' . $component->id);
        $response->assertStatus(200);
        $response->assertExactJson([
            'message' => "Component Delete Operation Was Successfull!",
        ]);
        $this->assertDatabaseMissing('Components', ['id' => $component->id]);
    }

    public function testgetAll()
    {
        $components = Component::factory()->count(5)->create();
        $response = $this->getJson($this->endpoint);
        $response->assertStatus(200);
        $response->assertJsonCount(5);
        $response->assertJson($components->toArray());
    }

    public function testGetOne()
    {
        $component = Component::factory()->create();
        $response = $this->getJson($this->endpoint . '/' . $component->id);
        $response->assertStatus(200);
        $response->assertJson($component->toArray());
    }
}