<?php

namespace Tests;

use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class CRUDServiceTestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $service;
    protected $modelFactory;
    protected $modelClass;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function validModelData()
    {
        return $this->modelFactory->make()->toArray();
    }

    public function testCreateModel()
    {
        $data = $this->validModelData();

        $createdModel = $this->service->store($data);
        $modeInstance = new $this->modelClass;
        $this->assertDatabaseHas($modeInstance->getTable(), $data);
        $this->assertInstanceOf($this->modelClass, $createdModel);
        $this->assertDatabaseHas($modeInstance->getTable(), ['id' => $createdModel->id]);
    }
}
