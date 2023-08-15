<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\RequestValidationErrorsHandler;

class TurbinePatch extends FormRequest
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
            'name' => 'sometimes|required|string|max:100|regex:/^[A-Za-z0-9\s]+$/',
            'description' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required',
            'farm_id' => 'sometimes|required|numeric|integer',
            'install_date' => 'sometimes|required|date|date_format:Y-m-d',
            'status' => 'sometimes|required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Turbine name field is required',
            'name.regex' => 'Turbine name field must only contain alpha-numeric characters',
            'name.string' => 'Turbine name field must be string',
            'address.required' => 'Turbine address field is required',
            'coordinates.string' => 'The coordinates field must be a string.',
        ];
    }
}
