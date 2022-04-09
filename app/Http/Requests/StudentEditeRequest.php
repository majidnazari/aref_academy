<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StudentEditeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            "first_name" =>["nullable"],
            "last_name" => ["nullable"],            
            "phone" => ["nullable","string"],
            "level" => ["nullable", Rule::in(['1', '2','3','4'])],
            "major" => ["nullable", Rule::in(['mathematics', 'experimental', 'humanities', 'art', 'other'])],
            "egucation_level" => ["nullable",Rule::in(['6', '7', '8', '9', '10', '11', '12', '13', '14'])]            
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
