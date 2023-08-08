<?php

namespace Tests;

use GuzzleHttp\Promise\Create;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Psy\Output\Theme;

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

    public function testGetAllModels()
    {
        $count = 5;
        $this->modelFactory->times($count)->Create();

        $allModels = $this->service->getAll();
        $this->assertInstanceOf(Collection::class, $allModels);
        $this->assertCount($count, $allModels);
        foreach ($allModels as $model) {
            $this->assertInstanceOf($this->modelClass, $model);
        }
    }
}
