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
        $this->withoutExceptionHandling();
        $validData =  Farm::factory()->make()->toArray();
        $response = $this->post($this->endpoint, $validData);
        $response->assertStatus(201);
        $response->assertJson([$validData]);
        $this->assertDatabaseHas('farms', $validData);
    }
}
