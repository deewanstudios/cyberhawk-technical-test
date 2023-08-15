<?php

namespace App\Services;

use App\Models\Farm;
use App\Services\CRUDService;


class FarmService extends CRUDService
{

    public function __construct()
    {
        parent::__construct(new Farm());
    }


    public function getFarmTurbines($id)
    {
        $farmTurbines = Farm::with('turbines')->where('id', $id)->get();
        // return response()->json($farmTurbines);
        return ($farmTurbines);
    }

}