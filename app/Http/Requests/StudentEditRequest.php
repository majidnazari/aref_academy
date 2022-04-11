<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StudentEditRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

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
            "phone" => ["nullable","size:11"],          
            "major" => ["nullable", Rule::in(['mathematics', 'experimental', 'humanities', 'art', 'other'])],
            "egucation_level" => ["nullable",Rule::in(['6', '7', '8', '9', '10', '11', '12', '13', '14'])]            
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
