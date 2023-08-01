<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Farm;
use App\Http\Requests\FarmRequest;
use App\Exceptions\MissingInputException;

class FarmTest extends TestCase
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
        $request = new FarmRequest();
        $validator =   $this->app['validator']->make($data, $request->rules());
        if ($validator->fails()) {
            $this->missingFields = $validator->errors()->keys();
            throw new MissingInputException($this->missingFields);
        }
    }


    public function testCreateFarmWithValidData()
    {
        $validData =  Farm::factory()->make()->toArray();
        dump($validData);
        $response = $this->post($this->endpoint, $validData);
        $response->assertStatus(201);
        $responseData = $response->json();
        $response->assertJson(['message' => 'New farm entity created successfully', 'data' => $validData]);
        $this->assertDatabaseHas('farms', $validData);
    }

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

        $emptyNameField = [
            'name' => '',
            'address' => $this->faker->address,
            /*
            'coordinates' => json_encode(['latitude' => $this->faker->latitude, 'longitude' => $this->faker->longitude]),
            'capacity' => $this->faker->numberBetween(config('testing.min_value'), config('testing.max_value')),
            'launched_date' => $this->faker->dateTimeBetween(config('testing.start_date'), config('testing.end_date')),
            'status' => $this->faker->randomElement(config('testing.farm_enum_values'))
            */

        ];

        /* $emptyAddressField = [
            'name' => $this->faker->colorName,
            'address' => '',
            'coordinates' => ['latitude' => $this->faker->latitude, 'longitude' => $this->faker->longitude],
        ];
        $emptyCoordinatesField = [
            'name' => $this->faker->colorName,
            'address' => $this->faker->address,
            'coordinates' => '',
        ]; */


        return [
            [$emptyNameField, ['name']],
            /*  [$emptyAddressField, ['address']],
            [$emptyCoordinatesField, ['coordinates']], */
        ];
    }
}
