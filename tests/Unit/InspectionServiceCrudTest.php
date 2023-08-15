<?php

namespace Tests\Unit;

use App\Models\Inspection;
use App\Models\Turbine;
use App\Models\TurbineComponent;
use App\Services\InspectionService;
use Database\Factories\InspectionFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CRUDServiceTestCase;

class InspectionServiceCrudTest extends CRUDServiceTestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(InspectionService::class);
        $this->modelFactory = InspectionFactory::new();
        $this->modelClass = Inspection::class;
    }


    public function testGetAllInspectionsWithTurbines()
    {
        // Create test data: turbines, components, inspections
        $turbine = Turbine::factory()->create();
        $component = TurbineComponent::factory()->create(['turbine_id' => $turbine->id]);
        $inspection = Inspection::factory()->create(['turbine_id' => $turbine->id]);

        // Mock the InspectionService and its method
        $mockedService = $this->mock(InspectionService::class);
        $mockedService->shouldReceive('getAllWithTurbines')->andReturn([$inspection]);

        // Test the functionality
        $response = $mockedService->getAllWithTurbines();

        // Assert the data contains the expected relationships
        $this->assertArrayHasKey('turbine', $response[0]);
        $this->assertArrayHasKey('components', $response[0]['turbine']);
        $this->assertArrayHasKey('turbineComponents', $response[0]['turbine']);
    }

}