<?php

namespace App\Services;

use App\Models\Turbine;
use App\Services\CRUDService;

/**
 * Class TurbineService.
 */
class TurbineService extends CRUDService
{

    public function __construct()
    {
        parent::__construct(new Turbine());
    }

    public function getWithRelationships()
    {
        $turbines = Turbine::with('turbineComponents.grade')->get();
        return response()->json($turbines);
    }
    public function getATurbineWithRelationships($id)
    {
        $turbine = Turbine::with('turbineComponents.grade')->where('id', $id)->get();
        return response()->json($turbine);
    }
}