<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Farm;
use App\Http\Requests\FarmStore;
use App\Exceptions\MissingInputException;
use Carbon\Carbon;

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
        $validator =   $this->app['validator']->make($data, $request->rules());
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
        $validData =  Farm::factory()->make()->toArray();
        $validData['address'] = "Sample Address";
        $response = $this->post($this->endpoint, $validData);
        $response->assertStatus(201);
        $response->assertJson(['message' => 'New farm entity created successfully', 'data' => $validData]);
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
        $enumValues =  ['Active', 'Under Construction', 'Retired'];
        $capacity =  rand(10, 300);

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
        $response =  $this->get($this->endpoint);
        $response->assertStatus(200);
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals([$expectedData], $responseData);
    }
}
