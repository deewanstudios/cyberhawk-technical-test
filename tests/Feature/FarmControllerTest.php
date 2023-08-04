<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Farm;
use App\Http\Requests\FarmStore;
use App\Exceptions\MissingInputException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FarmControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $endpoint = "api/farms";
    protected $missingFields = [];

    /**
     * ValidateInput
     *
     * @param  mixed $data
     * @return void
     */

    protected function ValidateInput($data)
    {
        $request = new FarmStore();
        $validator = $this->app['validator']->make($data, $request->rules());
        if ($validator->fails()) {
            $this->missingFields = $validator->errors()->keys();
            throw new MissingInputException($this->missingFields);
        }
    }


    /**
     * testCreateFarmWithValidData
     *
     * @return void
     */
    public function testCreateFarmWithValidData()
    {
        $validData = Farm::factory()->make()->toArray();
        $validData['address'] = "Sample Address";
        $response = $this->post($this->endpoint, $validData);
        $response->assertStatus(201);
        $response->assertJson(
            [
                'message' => 'New Farm Entity Created Successfully!',
                'data' => $validData
            ]
        );
        $this->assertDatabaseHas('farms', $validData);
    }



    /**
     * testCreateFarmWithInvalidData
     *
     * @param  mixed $invalidData
     * @param  mixed $expectedValidationFields
     * @return void
     */

    /**
     * @dataProvider invalidFarmDataProvider
     */
    public function testCreateFarmWithInvalidData($invalidData, $expectedValidationFields)
    {
        $response = $this->post($this->endpoint, $invalidData);
        $response->assertStatus(422);
        $responseData = $response->json();
        $this->assertEquals("Input Validation Failed!!", $responseData['error']);
        $this->assertStringContainsString("Your request is missing the following required input field(s)!", $responseData["message"]);
        $this->assertDatabaseMissing('farms', $invalidData);
    }

    public function invalidFarmDataProvider()
    {
        $date = date('Y-m-d', strtotime('-' . rand(0, 18) . ' years'));
        $enumValues = ['Active', 'Under Construction', 'Retired'];
        $capacity = rand(10, 300);

        $emptyNameField = [
            'name' => '',
            'address' => 'Sample Address',
            'coordinates' => 'Sample Cordinates',
            'capacity' => rand(1, 100),
            'launched_date' => $date,
            'status' => $enumValues[array_rand($enumValues)]
        ];
        $emptyAddressField = [
            'name' => 'Sample Name',
            'address' => '',
            'coordinates' => 'Sample Cordinates',
            'capacity' => $capacity,
            'launched_date' => $date,
            'status' => $enumValues[array_rand($enumValues)]
        ];
        $emptyCoordinatesField = [
            'name' => 'Sample Name',
            'address' => 'Sample Address',
            'coordinates' => '',
            'capacity' => $capacity,
            'launched_date' => $date,
            'status' => $enumValues[array_rand($enumValues)]
        ];
        $emptyCapacityField = [
            'name' => 'Sample Name',
            'address' => 'Sample Address',
            'coordinates' => 'Sample coordinates',
            'capacity' => '',
            'launched_date' => $date,
            'status' => $enumValues[array_rand($enumValues)]
        ];
        $emptyDateField = [
            'name' => 'Sample Name',
            'address' => 'Sample Address',
            'coordinates' => 'Sample coordinates',
            'capacity' => $capacity,
            'launched_date' => '',
            'status' => $enumValues[array_rand($enumValues)]
        ];
        $emptyStatusField = [
            'name' => 'Sample Name',
            'address' => 'Sample Address',
            'coordinates' => 'Sample coordinates',
            'capacity' => $capacity,
            'launched_date' => $date,
            'status' => ''
        ];

        return [
            [$emptyNameField, ['name']],
            [$emptyAddressField, ['address']],
            [$emptyCoordinatesField, ['coordinates']],
            [$emptyCapacityField, ['capacity']],
            [$emptyDateField, ['launched_date']],
            [$emptyStatusField, ['status']],
        ];
    }

    /**
     * testGetAllFarms
     *
     * @return void
     */
    public function testGetAllFarms()
    {
        $farm = Farm::factory()->create();
        $expectedData = $farm->toArray();
        $expectedData['launched_date'] = Carbon::parse($expectedData['launched_date'])->format('Y-m-d H:i:s');
        $response = $this->get($this->endpoint);
        $response->assertStatus(200);
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals([$expectedData], $responseData);
    }

    /**
     * testGetSingleFarm
     *
     * @return void
     */
    public function testGetSingleFarm()
    {
        $this->withoutExceptionHandling();
        $farm = Farm::factory()->create();
        $expectedData = $farm->toArray();
        $expectedData['launched_date'] = Carbon::parse($expectedData['launched_date'])->format('Y-m-d H:i:s');
        $response = $this->get($this->endpoint . '/' . $farm->id);
        $response->assertStatus(200);
        $response->assertJson($expectedData);
    }

    public function testFarmUpdate()
    {
        $farm = Farm::factory()->create();
        $date = Carbon::create('-' . rand(config('testing.min_value'), config('testing.max_value')) . 'years')->format('Y-m-d');
        $enum = config('testing.farm_enum_values');
        $updateFarmData = [
            'name' => 'Updated Farm Name',
            'address' => 'Updated Farm Address',
            'coordinates' => 'Updated Farm Coordinates',
            'capacity' => rand(config('testing.min_value'), config('testing.max_value')),
            'launched_date' => $date,
            'status' => $enum[array_rand($enum)]
        ];
        Farm::where('id', $farm->id)->update($updateFarmData);
        $response = $this->put($this->endpoint . '/' . $farm->id, $updateFarmData);
        $response->assertStatus(200);
        $updatedFarm = Farm::find($farm->id);
        // format updated farm's launched date to match expected response data
        $updatedFarm['launched_date'] = Carbon::parse($updatedFarm['launched_date'])->format('Y-m-d');
        $response->assertJson(
            [
                'message' => 'Farm Update Operation Was Successfull!',
                'data' => $updatedFarm->toArray()
            ]
        );

        $this->assertEquals($updateFarmData['name'], $updatedFarm['name']);
        $this->assertEquals($updateFarmData['address'], $updatedFarm['address']);
        $this->assertEquals($updateFarmData['coordinates'], $updatedFarm['coordinates']);
        $this->assertEquals($updateFarmData['capacity'], $updatedFarm['capacity']);
        $this->assertEquals($updateFarmData['launched_date'], $updatedFarm['launched_date']);
        $this->assertEquals($updateFarmData['status'], $updatedFarm['status']);
        $this->assertDatabaseHas('farms', $updatedFarm->toArray());
    }

    public function testFarmPatch()
    {
        $this->withoutExceptionHandling();
        $farm = Farm::factory()->create();
        $farmPatchData = [
            'name' => 'Farm Name Patch'
        ];
        Farm::where('id', $farm->id)->update($farmPatchData);
        $response = $this->patch($this->endpoint . '/' . $farm['id'], $farmPatchData);
        $response->assertStatus(200);
        $patchedfarm = Farm::find($farm->id);
        // format patched farm's launched date to match expected response data
        $patchedfarm['launched_date'] = Carbon::parse($patchedfarm['launched_date'])->format('Y-m-d H:i:s');
        $response->assertJson(
            [
                'message' => 'Farm Patch Operation Was Successfull!',
                'data' => $patchedfarm->toArray()
            ]
        );
        $this->assertEquals($farmPatchData['name'], $patchedfarm['name']);
    }

    public function testFarmDelete()
    {
        $this->withoutExceptionHandling();
        $farm = Farm::factory()->create();
        $response = $this->delete($this->endpoint . '/' . $farm->id);
        $response->assertStatus(200);
        $response->assertJson(
            [
                'data' => 'Farm Resource Deleted Successfull'
            ],
            200
        );

        $this->assertDatabaseMissing('farms', ['id' => $farm->id]);
    }
}
