<?php

namespace Tests\Unit;

use App\Models\Component;
use App\Services\ComponentService;
use Database\Factories\ComponentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CRUDServiceTestCase;

class ComponentServiceCrudTest extends CRUDServiceTestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(ComponentService::class);
        $this->modelFactory = ComponentFactory::new();
        $this->modelClass = Component::class;
    }
}