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

    public function __construct(InspectionService $inspectionService, FormRequest $request)
    {
        parent::__construct($inspectionService);
        $this->objectType = 'Inspection';
    }

    public function store(InspectionStore $request)
    {
        return parent::create($request, $this->objectType);
    }

    public function update(InspectionStore $request, Inspection $component)
    {
        return parent::updateAll($request, $component, $this->objectType);
    }

    public function edit(InspectionPatch $request, Inspection $component)
    {
        return parent::patch($request, $component->id, $this->objectType);
    }

    public function delete(Inspection $component)
    {
        return parent::destroy($component, $this->objectType);
    }

    public function allComponents()
    {
        return parent::all();
    }

    public function show(Inspection $component)
    {
        return parent::single($component->id);
    }
}