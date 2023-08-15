<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\CRUDController;
use App\Models\Turbine;
use Illuminate\Http\Request;
use App\Services\TurbineService;
use App\Http\Requests\TurbinePatch;
use App\Http\Requests\TurbineStore;
use App\Models\Inspection;
use Illuminate\Foundation\Http\FormRequest;


class TurbineController extends CRUDController
{
    /**
     * Summary of createdObjectType
     * @var 
     */
    private $createdObjectType;
    /**
     * Summary of service
     * @var 
     */
    private $service;
    /**
     * Instantiation of member properties, call to parent constructor and dependency injection
     * @param \App\Services\TurbineService $turbineService
     * @param \Illuminate\Foundation\Http\FormRequest $request
     */
    public function __construct(TurbineService $turbineService, FormRequest $request)
    {
        parent::__construct($turbineService);
        $this->createdObjectType = 'Turbine';
        $this->service = new TurbineService();
    }
    /**
     * Store created Turbine entity
     * @param \App\Http\Requests\TurbineStore $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store(TurbineStore $request)
    {
        return parent::create($request, $this->createdObjectType);
    }

    /**
     * Perform patial update on a Turbine entity
     * @param \App\Http\Requests\TurbinePatch $request
     * @param \App\Models\Turbine $turbine
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function edit(TurbinePatch $request, Turbine $turbine)
    {
        return parent::patch($request, $turbine->id, $this->createdObjectType);
    }

    /**
     * Perform full update on a Turbine entity
     * @param \App\Http\Requests\TurbineStore $request
     * @param \App\Models\Turbine $turbine
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(TurbineStore $request, Turbine $turbine)
    {
        return parent::updateAll($request, $turbine, $this->createdObjectType);
    }

    /**
     * Delete a Turbine entity
     * @param \App\Models\Turbine $turbine
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function delete(Turbine $turbine)
    {
        return parent::destroy($turbine, $this->createdObjectType);
    }

    /**
     * Retrieve all turbines, along with their relationships
     * @return mixed
     */
    public function allTurbines()
    {

        return $this->service->getWithRelationships();
    }

    /**
     * Retrieve a single Turbine along with its relationships
     * @param \App\Models\Turbine $turbine
     * @return mixed
     */
    public function show(Turbine $turbine)
    {
        return $this->service->getATurbineWithRelationships($turbine->id);
    }

    public function turbineInspections(Turbine $turbine)
    {
        return $this->service->getTurbineInspections($turbine->id);
    }
    public function turbineInspection(Turbine $turbine, Inspection $inspection)
    {
        return $this->service->getTurbineInspection($turbine->id, $inspection->id);
    }
}