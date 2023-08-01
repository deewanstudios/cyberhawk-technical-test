<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\MissingInputException;
use Illuminate\Validation\Rule;

class FarmStore extends FormRequest
{
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
        /* 'name' => 'required',
        'address' => 'required',
        'coordinates' => 'required',
        'capacity' => 'required',
        'launched_date' => 'required',
        'status' => 'required'
        |in:Active,Under COnstruction, Retired
        */
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

    protected function failedValidation(Validator $validator)
    {
        $missingInputs = [];
        foreach ($this->rules() as $input => $rules) {
            if ($validator->errors()->has($input)) {
                $missingInputs[$input] = $validator->errors()->first($input);
            }
        }
        throw new MissingInputException($missingInputs);
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
