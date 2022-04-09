<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StudentCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "first_name" =>["required"],
            "last_name" => ["required"],            
            "phone" => ["required","string"],
            "level" => ["required", Rule::in(['1', '2','3','4'])],
            "major" => ["required", Rule::in(['mathematics', 'experimental', 'humanities', 'art', 'other'])],
            "egucation_level" => ["required",Rule::in(['6', '7', '8', '9', '10', '11', '12', '13', '14'])]            
           ];
    }
    public function  errorValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                "details" => $validator->errors(),
                "success" => false,
                'message'   => 'Validation errors',
                "code"  =>400
            ]
            ));
    }
}
