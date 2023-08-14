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

    public function __construct(InspectionService $inspectionService, FormRequest $request)
    {
        parent::__construct($inspectionService);
        $this->objectType = 'Inspection';
        $this->service = new InspectionService();
    }

    public function store(InspectionStore $request)
    {
        return parent::create($request, $this->objectType);
    }

    public function update(InspectionStore $request, Inspection $inspection)
    {
        return parent::updateAll($request, $inspection, $this->objectType);
    }

    public function edit(InspectionPatch $request, Inspection $inspection)
    {
        return parent::patch($request, $inspection->id, $this->objectType);
    }

    public function delete(Inspection $inspection)
    {
        return parent::destroy($inspection, $this->objectType);
    }

    public function allInspections()
    {
        return $this->service->getAllWithRelationships();
    }

    public function show(Inspection $inspection)
    {
        return $this->service->getAnInspectionWithRelationships($inspection->id);
    }
}