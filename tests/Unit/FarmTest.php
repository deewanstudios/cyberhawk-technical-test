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

    public function testUpdateAFarm()
    {
        $farm = Farm::factory()->create();
        $data = [
            'name' => 'Updated Farm Name',
            'address' => 'Updated Farm Address',
            'coordinates' => 'Updated Farm Coordinates',
            'capacity' => '10',
            'launched_date' => Carbon::create('- 10 years'),
            'status' => 'Active'
        ];
        Farm::where('id', $farm->id)->update($data);
        $updatedFarm = Farm::find($farm->id);
        $this->assertEquals($data['name'], $updatedFarm['name']);
        $this->assertEquals($data['address'], $updatedFarm['address']);
        $this->assertEquals($data['coordinates'], $updatedFarm['coordinates']);
        $this->assertEquals($data['capacity'], $updatedFarm['capacity']);
        $this->assertEquals($data['launched_date'], $updatedFarm['launched_date']);
        $this->assertEquals($data['status'], $updatedFarm['status']);
    }

    public function testDeleteAFarm()
    {
        $farm = Farm::factory()->create();
        Farm::destroy($farm->id);
        $this->assertDatabaseMissing('farms', ['id' => $farm->id]);
    }
}
