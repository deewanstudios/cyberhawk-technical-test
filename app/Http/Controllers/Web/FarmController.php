<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\CRUDController;
use App\Models\Farm;
use App\Services\FarmService;

class FarmController extends CRUDController
{
    private $service;

    public function __construct(FarmService $farmService)
    {
        parent::__construct($farmService);
        $this->service = new FarmService();
    }


    public function index()
    {
        $farms = parent::all();
        return view('farms', ['farms' => $farms]);
    }

    public function show(Farm $farm)
    {
        $farm = parent::single($farm->id);
        return view('farm', ['farm' => $farm]);
    }

    public function farmTurbines(Farm $farm)
    {
        $farms = $this->service->farmTurbines($farm->id);
        return view('farm-turbines', ['farms' => $farms]);

    }
}