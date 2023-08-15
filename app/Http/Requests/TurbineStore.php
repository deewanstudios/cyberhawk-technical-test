<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\RequestValidationErrorsHandler;

class TurbineStore extends FormRequest
{
    use RequestValidationErrorsHandler;


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            //
            'name' => 'required|string|max:100|regex:/^[A-Za-z0-9\s]+$/',
            'description' => 'required|string|max:255',
            'location' => 'required',
            'farm_id' => 'required|numeric|integer',
            'install_date' => 'required|date|date_format:Y-m-d',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Turbine name field is required',
            'name.regex' => 'Turbine name field must only contain alpha-numeric characters',
            'name.string' => 'Turbine name field must be string',
            'address.required' => 'Turbine address field is required',
            'location.string' => 'The coordinates field must be a string.',
            'farm_id.required' => 'A turbine must belong to a farm'
        ];
    }
}
