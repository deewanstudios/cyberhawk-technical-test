<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;
use App\Services\ComponentService;
use App\Http\Requests\ComponentPatch;
use App\Http\Requests\ComponentStore;
use Illuminate\Foundation\Http\FormRequest;

class ComponentController extends CRUDController
{
    //
    private $objectType;

    public function __construct(ComponentService $componentService, FormRequest $request)
    {
        parent::__construct($componentService);
        $this->objectType = 'Component';
    }

    public function store(ComponentStore $request)
    {
        return parent::create($request, $this->objectType);
    }

    public function update(ComponentStore $request, Component $component)
    {
        return parent::updateAll($request, $component, $this->objectType);
    }

    public function edit(ComponentPatch $request, Component $component)
    {
        return parent::patch($request, $component->id, $this->objectType);
    }

    public function delete(Component $component)
    {
        return parent::destroy($component, $this->objectType);
    }

    public function allComponents()
    {
        return parent::all();
    }

    public function show(Component $component)
    {
        return parent::single($component->id);
    }
}
