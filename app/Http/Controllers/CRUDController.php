<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CRUDService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

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

    public function updateAll(FormRequest $request, Model $model, $updatedObjectType)
    {
        $model->update($request->validated());
        $data = $this->crudService->update($model);
        return response()->json([
            'message' => "{$updatedObjectType} Update Operation Was Successfull!",
            'data' => $data
        ]);
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
