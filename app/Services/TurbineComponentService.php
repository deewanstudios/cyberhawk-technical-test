<?php

namespace App\Services;
use App\Models\TurbineComponent;

/**
 * Class TurbineComponentService.
 */
class TurbineComponentService extends CRUDService
{
    public function __construct()
    {
        parent::__construct(new TurbineComponent());
    }
}