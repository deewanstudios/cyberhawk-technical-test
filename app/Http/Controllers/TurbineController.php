<?php

namespace App\Http\Controllers;

use App\Services\TurbineService;
use App\Http\Requests\TurbineStore;
use Illuminate\Http\Request;

class TurbineController extends CRUDController
{
    //
    public function __construct(TurbineService $turbineService, TurbineStore $request)
    {
        parent::__construct($turbineService, $request);
    }

    /* public function getCrudService()
    {
        return app(TurbineService::class);
    }
 */
    /* public function store(TurbineStore $request)
    {
        return parent::store($request);
    }
    */

    public function store(TurbineStore $request)
    {
        $createdObjectType = "Turbine";
        return parent::create($request, $createdObjectType);
    }
}
