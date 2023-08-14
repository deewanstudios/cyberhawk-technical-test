<?php

namespace App\Services;
use App\Models\TurbineComponent;


class TurbineComponentService extends CRUDService
{
    /**
     * Call to parent constructor and dependency injection
     */
    public function __construct()
    {
        parent::__construct(new TurbineComponent());
    }
}