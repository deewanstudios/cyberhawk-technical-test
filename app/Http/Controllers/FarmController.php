<?php

namespace App\Http\Controllers;

use App\Http\Requests\FarmPatch;
use App\Models\Farm;
use App\Http\Requests\FarmStore;
use App\Exceptions\MissingInputException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FarmController extends Controller
{


    /**
     * Retrieve a list of all farms from the database or cache if available.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of farms.
     */

    public function index()
    {
        $farms = cache()->remember('farms', 60, function () {
            $farms = Farm::all();

            if ($farms->isEmpty()) {

                throw new EmptyResponseException();
            }
            return $farms;
        });
        return response()->json($farms);
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
        return response()->json(
            [
                'message' => 'New Farm Entity Created Successfully!',
                'data' => $farm
            ],
            201
        );
    }

    public function update(FarmStore $farmStore, Farm $farm)
    {
        $validateData = $farmStore->validated();
        $farm->update($validateData);
        return response()->json(
            [
                'message' => 'Farm Update Operation Was Successfull!',
                'data' => $farm
            ]
        );
    }

    public function edit(FarmPatch $farmPatch, Farm $farm)
    {
        $validateData = $farmPatch->validated();
        $farm->fill($validateData);
        $farm->save();
        return response()->json([
            'message' => 'Farm Patch Operation Was Successfull!',
            'data' => $farm
        ]);
    }


    public function delete(Farm $farm)
    {


        if (!$farm->delete()) {
            // throw new ApiResourceNotFoundException();
            throw new ModelNotFoundException('The Farm Resources That You Have Requested, Does Not Exist!!!');
        }
        return response()->json(
            [
                'data' => 'Farm Resource Deleted Successfull'
            ],
            200
        );
    }
}
