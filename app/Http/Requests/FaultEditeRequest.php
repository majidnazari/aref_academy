<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaultEditeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "description" =>  "required|min:3|unique:faults,description",
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'details'      => $validator->errors(),
            'code'      =>400
        ],400
        ));
    }
}
