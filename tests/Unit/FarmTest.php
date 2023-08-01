<?php

namespace Tests\Unit;

use App\Models\Farm;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FarmTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * [testGetAllFarms description]
     *
     * @return  [type]  [return description]
     */
    public function testGetAllFarms()
    {
        Farm::factory()->count(10)->create();
        $farms = Farm::all();
        $this->assertCount(10, $farms);
        foreach ($farms as $farm) {
            $this->assertInstanceOf(Farm::class, $farm);;
        }
    }
}
