<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\MissingInputException;
use Illuminate\Validation\Rule;
use App\Http\Requests\Concerns\FarmValidationErrorsHandler;

class FarmStore extends FormRequest
{
    use FarmValidationErrorsHandler;
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
}
