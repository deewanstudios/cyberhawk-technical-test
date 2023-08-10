<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TurbineComponentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    protected $endpoint;
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }
}