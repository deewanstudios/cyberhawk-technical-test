<?php

namespace App\Http\Controllers;

use App\Services\CRUDService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CRUDController extends Controller
{
    protected $crudService;
    protected $formRequest;

    public function __construct(CRUDService $crudService)
    {
        $this->crudService = $crudService;
    }

    public function create(FormRequest $request, $createdObjectType)
    {
        $data = $this->crudService->store($request->validated());
        return response()->json([
            'message' => "New {$createdObjectType} Entity Created Successfully!",
            'data' => $data
        ], 201);
    }

    public function patch(FormRequest $request, $id, $updatedObjectType)
    {
        $data = $this->crudService->edit($id, $request->validated());
        return response()->json([
            'message' => "{$updatedObjectType} Patch Operation Was Successfull!",
            'data' => $data
        ]);
    }
}
