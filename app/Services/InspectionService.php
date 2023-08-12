<?php

namespace App\Services;

use App\Models\Inspection;

new Inspection;

/**
 * Class InspectionService.
 */
class InspectionService extends CRUDService
{
    public function __construct()
    {
        parent::__construct(new Inspection());
    }

}