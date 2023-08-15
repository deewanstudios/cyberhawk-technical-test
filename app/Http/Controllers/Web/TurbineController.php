<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\CRUDController;
use App\Models\Inspection;
use App\Models\Turbine;
use App\Services\TurbineService;

class TurbineController extends CRUDController
{
    private $service;

    public function __construct(TurbineService $turbineService)
    {
        parent::__construct($turbineService);
        $this->service = new TurbineService();

    }

    
    public function turbineInspections(Turbine $turbine)
    {
        return $this->service->turbineInspections($turbine->id);
    }
    public function turbineInspection(Turbine $turbine, Inspection $inspection)
    {
        return $this->service->turbineInspection($turbine->id, $inspection->id);
    }
}