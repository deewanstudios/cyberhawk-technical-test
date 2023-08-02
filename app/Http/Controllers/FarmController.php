<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;
use App\Http\Requests\FarmStore;
use App\Exceptions\MissingInputException;
use Carbon\Carbon;

class FarmController extends Controller
{


    /**
     * Retrieve a list of all farms from the database or cache if available.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of farms.
     */
    
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
    /**
     * Show the details of a specific farm.
     *
     * @param Farm $farm The Farm object representing the farm to be shown.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the farm details.
     */

    public function show(Farm $farm)
    {
        $cachedResponse = cache()->remember("farm_{$farm->id}", 60, function () use ($farm) {
            return Farm::findOrFail($farm->id);
        });
        return response()->json($cachedResponse);
    }


    /**
     * Store a new farm entity in the database.
     *
     * @param FarmStore $request The HTTP request object containing the validated form input.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success of the operation.
     */
    public function store(FarmStore $request)
    {
        try {
            $farm = Farm::create($request->validated());
            return response()->json(['message' => 'New farm entity created successfully', 'data' => $farm], 201);
        } catch (MissingInputException $e) {
        }
    }
}
