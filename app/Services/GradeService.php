<?php

namespace App\Services;

use App\Models\Grade;


class GradeService extends CRUDService
{
    /**
     * Call to parent constructor and dependency injection
     */
    public function __construct()
    {
        parent::__construct(new Grade());
    }
}