<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CRUDService
{

    /**
     * member property for model
     * @var 
     */
    protected $model;

    /**
     * Instantiation of member properties, and dependency injection
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Store data into provided model
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->model::create($data);
    }

    /**
     * Full update of of supplied model object
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return Model
     */
    public function update(Model $model)
    {

        $this->model->update($model->toArray());
        return $model;
    }

    /**
     * Partial update of supplied model
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function edit($id, array $data)
    {
        $object = $this->model::findOrFail($id);
        $object->fill($data);
        $object->save();
        return $object;
    }

    /**
     * Remove supplied model from database
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool|null
     */
    public function destroy(Model $model)
    {
        return $model->delete();
    }

    /**
     * Retrieve all instances of supplied model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model::all();
    }

    /**
     * Retrieve a single instance of supplied model by its id
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return null;
        }
    }
}