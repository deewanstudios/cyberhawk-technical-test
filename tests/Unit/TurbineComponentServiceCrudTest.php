<?php

namespace Tests\Unit;

use App\Models\TurbineComponent;
use App\Services\TurbineComponentService;
use Database\Factories\TurbineComponentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CRUDServiceTestCase;

class TurbineComponentServiceCrudTest extends CRUDServiceTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(TurbineComponentService::class);
        $this->modelFactory = TurbineComponentFactory::new();
        $this->modelClass = TurbineComponent::class;
    }
}