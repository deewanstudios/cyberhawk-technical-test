<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\CRUDController;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Services\GradeService;
use App\Http\Requests\GradePatch;
use App\Http\Requests\GradeStore;
use Illuminate\Foundation\Http\FormRequest;


class GradeController extends CRUDController
{
    //
    /**
     * objectType
     * @var 
     */
    private $objectType;

    /**
     *Instantiation of member properties, call to parent constructor and dependency injection
     * @param \App\Services\GradeService $gradeService
     * @param \Illuminate\Foundation\Http\FormRequest $request
     */
    public function __construct(GradeService $gradeService, FormRequest $request)
    {
        parent::__construct($gradeService);
        $this->objectType = 'Grade';
    }

    /**
     * Store created Grade entity
     * @param \App\Http\Requests\GradeStore $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store(GradeStore $request)
    {
        return parent::create($request, $this->objectType);
    }

    /**
     * Perform full update on a Grade entity
     * @param \App\Http\Requests\GradeStore $request
     * @param \App\Models\Grade $grade
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(GradeStore $request, Grade $grade)
    {

        return parent::updateAll($request, $grade, $this->objectType);
    }

    /**
     * Perform partial update on a Grade entity
     * @param \App\Http\Requests\GradePatch $request
     * @param \App\Models\Grade $grade
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function edit(GradePatch $request, Grade $grade)
    {
        return parent::patch($request, $grade->id, $this->objectType);
    }

    /**
     * Delete a Grade entity
     * @param \App\Models\Grade $grade
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function delete(Grade $grade)
    {
        return parent::destroy($grade, $this->objectType);
    }

    /**
     * Retrieve all grades
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allGrades()
    {
        return parent::all();
    }

    /**
     * Retrieve a single grade
     * @param \App\Models\Grade $grade
     * @return mixed
     */
    public function show(Grade $grade)
    {
        return parent::single($grade->id);
    }
}