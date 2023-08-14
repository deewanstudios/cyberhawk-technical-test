<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\RequestValidationErrorsHandler;
use Illuminate\Foundation\Http\FormRequest;

class InspectionPatch extends FormRequest
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
            'turbine_id' => 'sometimes|required|numeric',
            'inspection_date' => 'sometimes|required',
            'grade' => 'sometimes|required|numeric'
        ];
    }
}