<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;
use App\Http\Requests\FarmStore;
use App\Exceptions\MissingInputException;

class FarmController extends Controller
{

    public function index()
    {
        try {
            $farms = cache()->remember('farms', 60, function () {
                $farms = Farm::all();

                if ($farms->isEmpty()) {

                    throw new EmptyResponseException();
                }
                return $farms;
            });
            return response()->json($farms);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function store(FarmStore $request)
    {
        try {
            $farm = Farm::create($request->validated());
            return response()->json(['message' => 'New farm entity created successfully', 'data' => $farm], 201);
        } catch (MissingInputException $e) {
        }
    }
}
