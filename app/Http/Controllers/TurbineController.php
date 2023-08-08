<?php

namespace App\Http\Controllers;

use App\Models\Turbine;
use Illuminate\Http\Request;
use App\Services\TurbineService;
use App\Http\Requests\TurbinePatch;
use App\Http\Requests\TurbineStore;
use Illuminate\Foundation\Http\FormRequest;

class TurbineController extends CRUDController
{
    //
    // protected $service;
    private $createdObjectType;
    public function __construct(TurbineService $turbineService, FormRequest $request)
    {
        parent::__construct($turbineService, $request);
        $this->createdObjectType = 'Turbine';
    }
    public function store(TurbineStore $request)
    {
        return parent::create($request, $this->createdObjectType);
    }

    public function edit(TurbinePatch $request, Turbine $turbine)
    {
        return parent::patch($request, $turbine->id, $this->createdObjectType);
    }

    public function update(TurbineStore $request,  Turbine $turbine)
    {
        return parent::updateAll($request, $turbine, $this->createdObjectType);
    }

    public function delete(Turbine $turbine)
    {
        return parent::destroy($turbine, $this->createdObjectType);
    }

    public function allTurbines()
    {
        return parent::all();
    }

    public function show(Turbine $turbine)
    {
        return parent::single($turbine->id);
    }
}
