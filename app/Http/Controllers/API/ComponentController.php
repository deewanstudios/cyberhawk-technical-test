<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\CRUDController;
use App\Models\Component;
use Illuminate\Http\Request;
use App\Services\ComponentService;
use App\Http\Requests\ComponentPatch;
use App\Http\Requests\ComponentStore;
use Illuminate\Foundation\Http\FormRequest;


class ComponentController extends CRUDController
{
    //
    /**
     * objectType
     * @var 
     */
    private $objectType;

    /**
     * Instantiation of member properties, call to parent constructor and dependency injection
     * @param \App\Services\ComponentService $componentService
     * @param \Illuminate\Foundation\Http\FormRequest $request
     */
    public function __construct(ComponentService $componentService, FormRequest $request)
    {
        parent::__construct($componentService);
        $this->objectType = 'Component';
    }

    /**
     * Store a created Component entity
     * @param \App\Http\Requests\ComponentStore $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store(ComponentStore $request)
    {
        return parent::create($request, $this->objectType);
    }

    /**
     * Perform full update on a Component entity
     * @param \App\Http\Requests\ComponentStore $request
     * @param \App\Models\Component $component
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(ComponentStore $request, Component $component)
    {
        return parent::updateAll($request, $component, $this->objectType);
    }

    /**
     * Perform partial update on a Component entity
     * @param \App\Http\Requests\ComponentPatch $request
     * @param \App\Models\Component $component
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function edit(ComponentPatch $request, Component $component)
    {
        return parent::patch($request, $component->id, $this->objectType);
    }

    /**
     * Delete a Componenet entity
     * @param \App\Models\Component $component
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function delete(Component $component)
    {
        return parent::destroy($component, $this->objectType);
    }

    /**
     * Retrieve all Components
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allComponents()
    {
        return parent::all();
    }

    /**
     * Retrieve a single Component entity
     * @param \App\Models\Component $component
     * @return mixed
     */
    public function show(Component $component)
    {
        return parent::single($component->id);
    }
}