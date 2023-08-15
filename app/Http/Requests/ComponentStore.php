<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\RequestValidationErrorsHandler;

class ComponentStore extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Component name field is required',
            'quantity' => 'Component quantity field is required'
        ];
    }
}
