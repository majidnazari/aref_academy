<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TeacherCreateRequest extends FormRequest
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
            "first_name" => ["required","string"], 
            "last_name" => ["required","string"],
            "mobile" =>["required","size:11"],
            "address" => ["required"],
            "user_id" =>["required" ,"int" ]
        ];
    }
    public function errorValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            "message" => "Validation error",
            "Details" => $validator->errors(),
            "code" => 400 
        ]));
    }
}
