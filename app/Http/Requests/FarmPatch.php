<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\FarmStore;

class FarmPatch extends FormRequest
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
            'name' => 'sometimes|required|string|max:100|regex:/^[A-Za-z0-9\s]+$/',
            'address' => 'sometimes|required|string|max:255',
            'coordinates' => 'sometimes|required',
            'capacity' => 'sometimes|required|numeric|integer',
            'launched_date' => 'sometimes|required|date|date_format:Y-m-d',
            'status' => 'sometimes|required'
        ];
    }
}