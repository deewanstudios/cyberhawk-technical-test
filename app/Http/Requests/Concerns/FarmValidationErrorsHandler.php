<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\MissingInputException;

trait FarmValidationErrorsHandler
{

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
