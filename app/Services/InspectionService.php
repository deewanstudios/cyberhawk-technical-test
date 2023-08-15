<?php

namespace App\Services;

use App\Models\Inspection;
use App\Services\CRUDService;

new Inspection;

class InspectionService extends CRUDService
{
    /**
     * Call to parent constructor and dependency injection
     */
    public function __construct()
    {
        parent::__construct(new Inspection());
    }

    /**
     * Method to retrieve all inspections, along with their relationships
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getAllWithRelationships()
    {
        $inspectionsWithTurbines = Inspection::with('turbine', 'turbine.components')->get();

        return response()->json($inspectionsWithTurbines);
    }



    /**
     * Method to retrieve an inspection, along with its reltionships
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getAnInspectionWithRelationships($id)
    {
        $inspection = Inspection::with('turbine', 'turbine.components')->where('id', $id)->get();
        return response()->json($inspection);
    }

}