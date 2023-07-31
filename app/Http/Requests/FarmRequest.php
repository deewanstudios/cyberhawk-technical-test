<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\MissingInputException;

class FarmRequest extends FormRequest
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
        return [
            //
            'name' => 'required|string|max:100'
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
            'name.required' => 'Farm name field is required'
        ];
    }
}
