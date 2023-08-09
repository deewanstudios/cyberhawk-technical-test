<?php

namespace App\Services;

use App\Models\Component;
use App\Services\CRUDService;

/**
 * Class ComponentService.
 */
class ComponentService extends CRUDService
{

    public function __construct()
    {
        parent::__construct(new Component);
    }
}