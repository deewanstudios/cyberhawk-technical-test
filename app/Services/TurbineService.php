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
}
