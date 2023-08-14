<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CRUDService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;

class CRUDController extends Controller
{
    /**
     * crudService
     * @var 
     */
    protected $crudService;
    /**
     * formRequest
     * @var 
     */
    protected $formRequest;

    /**
     * Instantion of $crudServive property and dependency injection of CRUDService
     * @param \App\Services\CRUDService $crudService
     */
    public function __construct(CRUDService $crudService)
    {
        $this->crudService = $crudService;
    }

    /**
     * CRUD method to create an entity
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param mixed $objectType
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function create(FormRequest $request, $objectType)
    {
        $data = $this->crudService->store($request->validated());
        return response()->json([
            'message' => "New {$objectType} Entity Created Successfully!",
            'data' => $data
        ], 201);
    }

    /**
     * CRUD method to perform a full update on an entity
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param mixed $objectType
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function updateAll(FormRequest $request, Model $model, $objectType)
    {
        $model->update($request->validated());
        $data = $this->crudService->update($model);
        return response()->json([
            'message' => "{$objectType} Update Operation Was Successfull!",
            'data' => $data
        ]);
    }

    /**
     * CRUD method to perform a partial update on an entity
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param mixed $id
     * @param mixed $objectType
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function patch(FormRequest $request, $id, $objectType)
    {
        $data = $this->crudService->edit($id, $request->validated());
        return response()->json([
            'message' => "{$objectType} Patch Operation Was Successfull!",
            'data' => $data
        ]);
    }

    /**
     * CRUD method to destroy an entity
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param mixed $objectType
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy(Model $model, $objectType)
    {
        $this->crudService->destroy($model);
        return response()->json([
            'message' => "{$objectType} Delete Operation Was Successfull!",
        ]);
    }

    /**
     * CRUD controller method to retrieve all available entities
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->crudService->getAll();
    }

    /**
     * CRUD controller method to retrieve a single entity by id
     * @param mixed $id
     * @return mixed
     */
    public function single($id)
    {
        return $this->crudService->getById($id);
    }
}