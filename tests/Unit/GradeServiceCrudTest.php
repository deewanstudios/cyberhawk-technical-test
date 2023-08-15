<?php

namespace Tests\Unit;

use App\Models\Grade;
use App\Services\GradeService;
use Tests\CRUDServiceTestCase;
use Database\Factories\GradeFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GradeServiceCrudTest extends CRUDServiceTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(GradeService::class);
        $this->modelFactory = GradeFactory::new();
        $this->modelClass = Grade::class;
    }
}
