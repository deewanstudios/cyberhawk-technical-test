<?php

namespace Tests\Unit;

use App\Models\Turbine;
use Tests\CRUDServiceTestCase;
use App\Services\TurbineService;
use Database\Factories\TurbineFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TurbineServiceCrudTest extends CRUDServiceTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(TurbineService::class);
        $this->modelFactory = TurbineFactory::new();
        $this->modelClass = Turbine::class;
    }
}
