<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CRUDService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;

class CRUDController extends Controller
{
    protected $crudService;
    protected $formRequest;

    public function __construct(CRUDService $crudService)
    {
        $this->crudService = $crudService;
    }

    public function create(FormRequest $request, $objectType)
    {
        $data = $this->crudService->store($request->validated());
        return response()->json([
            'message' => "New {$objectType} Entity Created Successfully!",
            'data' => $data
        ], 201);
    }

    public function updateAll(FormRequest $request, Model $model, $objectType)
    {
        $model->update($request->validated());
        $data = $this->crudService->update($model);
        return response()->json([
            'message' => "{$objectType} Update Operation Was Successfull!",
            'data' => $data
        ]);
    }

    public function patch(FormRequest $request, $id, $objectType)
    {
        $data = $this->crudService->edit($id, $request->validated());
        return response()->json([
            'message' => "{$objectType} Patch Operation Was Successfull!",
            'data' => $data
        ]);
    }

    public function destroy(Model $model, $objectType)
    {
        $this->crudService->destroy($model);
        return response()->json([
            'message' => "{$objectType} Delete Operation Was Successfull!",
        ]);
    }

    public function all()
    {
        return $this->crudService->getAll();
    }

    public function single($id)
    {
        return $this->crudService->getById($id);
    }
}