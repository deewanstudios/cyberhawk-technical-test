<?php

namespace App\Http\Controllers;

use App\Http\Requests\FarmPatch;
use App\Models\Farm;
use App\Http\Requests\FarmStore;
use App\Exceptions\MissingInputException;

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

        $farm = Farm::create($request->validated());
        return response()->json(['message' => 'New farm entity created successfully', 'data' => $farm], 201);

    }

    public function update(FarmStore $farmStore, Farm $farm)
    {
        $validateData = $farmStore->validated();
        $farm->update($validateData);
        return response()->json(
            [
                'message' => 'Farm Updated successfully',
                'data' => $farm
            ]
        );
    }

    public function edit(FarmPatch $farmPatch, Farm $farm)
    {
        $validateData = $farmPatch->validated();
        $farm->update($validateData);
        return response()->json([
            'message' => 'Farm Patch Operation Was Successfull',
            'data' => $farm
        ]);
    }
}