<?php

namespace App\Services;

use App\Models\Turbine;
use App\Services\CRUDService;


class TurbineService extends CRUDService
{

    /**
     * Call to parent constructor and dependency injection
     */
    public function __construct()
    {
        parent::__construct(new Turbine());
    }

    /**
     * Method to retrieve all turbines, along with their relationships
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getWithRelationships()
    {
        $turbines = Turbine::with('turbineComponents.grade', 'turbineComponents.component')->get();
        return response()->json($turbines);
    }
    /**
     * Method to retrieve a turbine, along with its relationships
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getATurbineWithRelationships($id)
    {
        $turbine = Turbine::with('turbineComponents.grade', 'turbineComponents.component')->where('id', $id)->get();
        return response()->json($turbine);
    }
}