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
        $turbines = Turbine::with('components.grade')->get();
        return response()->json($turbines);
    }
}
