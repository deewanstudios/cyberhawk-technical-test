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

}