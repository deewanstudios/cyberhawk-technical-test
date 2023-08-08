<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\RequestValidationErrorsHandler;

class FarmStore extends FormRequest
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
            'address' => 'required|string|max:255',
            'coordinates' => 'required',
            'capacity' => 'required|numeric|integer',
            'launched_date' => 'required|date|date_format:Y-m-d',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Farm name field is required',
            'name.regex' => 'Farm name field must only contain alpha-numeric characters',
            'name.string' => 'Farm name field must be string',
            'address.required' => 'Farm address field is required',
            'coordinates.string' => 'The coordinates field must be a string.',
        ];
    }
}
