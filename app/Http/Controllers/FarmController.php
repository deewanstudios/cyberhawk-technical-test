<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;
use App\Http\Requests\FarmRequest;
use App\Exceptions\MissingInputException;

class FarmController extends Controller
{
    public function store(FarmRequest $request)
    {
        try {
            $farm = Farm::create($request->validated());
            return response()->json(['message' => 'New farm entity created successfully', 'data' => $farm], 201);
        } catch (MissingInputException $e) {
        }
    }
}
