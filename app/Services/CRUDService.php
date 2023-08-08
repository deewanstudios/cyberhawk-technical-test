<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class CRUDService.
 */
class CRUDService
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function store(array $data)
    {
        return $this->model::create($data);
    }

    public function update(Model $model)
    {

        $this->model->update($model->toArray());
        return $model;
    }

    public function edit($id, array $data)
    {
        $object = $this->model::findOrFail($id);
        $object->fill($data);
        $object->save();
        return $object;
    }

    public function getAll()
    {
        return $this->model::all();
    }

    public function getById(int $id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }
}
