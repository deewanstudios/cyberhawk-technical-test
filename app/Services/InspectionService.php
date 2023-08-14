<?php

namespace App\Services;

use App\Models\Inspection;
use App\Services\CRUDService;

new Inspection;

/**
 * Class InspectionService.
 */
class InspectionService extends CRUDService
{
    public function __construct()
    {
        parent::__construct(new Inspection());
    }

    public function getAllWithRelationships()
    {
        $inspectionsWithTurbines = Inspection::with('turbine', 'turbine.components')->get();

        return response()->json($inspectionsWithTurbines);
    }



    public function getAnInspectionWithRelationships($id)
    {
        $inspection = Inspection::with('turbine', 'turbine.components')->where('id', $id)->get();
        return response()->json($inspection);
    }

}