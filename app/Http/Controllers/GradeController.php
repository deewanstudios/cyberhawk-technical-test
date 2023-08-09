<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Services\GradeService;
use App\Http\Requests\GradePatch;
use App\Http\Requests\GradeStore;
use Illuminate\Foundation\Http\FormRequest;

class GradeController extends CRUDController
{
    //
    private $objectType;

    public function __construct(GradeService $gradeService, FormRequest $request)
    {
        parent::__construct($gradeService, $request);
        $this->objectType = 'Grade';
    }

    public function store(GradeStore $request)
    {
        return parent::create($request, $this->objectType);
    }

    public function update(GradeStore $request, Grade $grade)
    {

        return parent::updateAll($request, $grade, $this->objectType);
    }

    public function edit(GradePatch $request, Grade $grade)
    {
        return parent::patch($request, $grade->id, $this->objectType);
    }

    public function delete(Grade $grade)
    {
        return parent::destroy($grade, $this->objectType);
    }

    public function allGrades()
    {
        return parent::all();
    }

    public function show(Grade $grade)
    {
        return parent::single($grade->id);
    }
}
