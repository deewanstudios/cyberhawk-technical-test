<?php

namespace App\Services;

use App\Models\Grade;

/**
 * Class GradeService.
 */
class GradeService extends CRUDService
{
    public function __construct()
    {
        parent::__construct(new Grade());
    }
}
