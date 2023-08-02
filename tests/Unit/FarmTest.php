<?php

namespace Tests\Unit;

use App\Models\Farm;
use Carbon\Carbon;
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
            $this->assertInstanceOf(Farm::class, $farm);
        }
    }

    public function testGetAFarm()
    {
        $farm = Farm::factory()->create();
        //  format the created farms date, so that it matches the retrieved farms date
        $farm["launched_date"] = Carbon::parse($farm['launched_date'])->format('Y-m-d H:i:s');
        $retrievedFarm = Farm::find($farm->id);
        // Assert that retrieved farm matches created farm
        $this->assertEquals($farm->id, $retrievedFarm->id);
        $this->assertEquals($farm->name, $retrievedFarm->name);
        $this->assertEquals($farm->address, $retrievedFarm->address);
        $this->assertEquals($farm->coordinates, $retrievedFarm->coordinates);
        $this->assertEquals($farm->capacity, $retrievedFarm->capacity);
        $this->assertEquals($farm->launched_date, $retrievedFarm->launched_date);
        $this->assertEquals($farm->status, $retrievedFarm->status);
    }
}
