<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\CRUDController;
use App\Http\Requests\InspectionPatch;
use App\Http\Requests\InspectionStore;
use App\Models\Inspection;
use App\Services\InspectionService;
use Illuminate\Foundation\Http\FormRequest;

class InspectionController extends CRUDController
{
    private $objectType;
    private $service;

    /**
     * Instantiation of member properties, call to parent constructor and dependency injection
     * @param \App\Services\InspectionService $inspectionService
     * @param \Illuminate\Foundation\Http\FormRequest $request
     */
    public function __construct(InspectionService $inspectionService, FormRequest $request)
    {
        parent::__construct($inspectionService);
        $this->objectType = 'Inspection';
        $this->service = new InspectionService();
    }

    /**
     * Store created Inspection entity
     * @param \App\Http\Requests\InspectionStore $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store(InspectionStore $request)
    {
        return parent::create($request, $this->objectType);
    }

    /**
     * Perform full update on an Inspection entity
     * @param \App\Http\Requests\InspectionStore $request
     * @param \App\Models\Inspection $inspection
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(InspectionStore $request, Inspection $inspection)
    {
        return parent::updateAll($request, $inspection, $this->objectType);
    }

    /**
     * Perform partial update on an Inspection entity
     * @param \App\Http\Requests\InspectionPatch $request
     * @param \App\Models\Inspection $inspection
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function edit(InspectionPatch $request, Inspection $inspection)
    {
        return parent::patch($request, $inspection->id, $this->objectType);
    }

    /**
     * Delete an Inspection entity
     * @param \App\Models\Inspection $inspection
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function delete(Inspection $inspection)
    {
        return parent::destroy($inspection, $this->objectType);
    }

    /**
     * Retrieve all of allInspections, along with their relationships
     * @return mixed
     */
    public function allInspections()
    {
        return $this->service->getAllWithRelationships();
    }

    /**
     * Retrieve a single Inspection along with its relationships
     * @param \App\Models\Inspection $inspection
     * @return mixed
     */
    public function show(Inspection $inspection)
    {
        return $this->service->getAnInspectionWithRelationships($inspection->id);
    }
}