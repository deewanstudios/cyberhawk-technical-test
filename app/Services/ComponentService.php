<?php

namespace App\Services;

use App\Models\Component;
use App\Services\CRUDService;


/**
 * Summary of ComponentService
 */
class ComponentService extends CRUDService
{

    /**
     * Call to parent constructor and dependency injection
     */
    public function __construct()
    {
        parent::__construct(new Component());
    }
}