<?php

namespace Tests\Unit;

use App\Models\Inspection;
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

    
}