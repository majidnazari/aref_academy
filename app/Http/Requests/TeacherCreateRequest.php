<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

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
            "first_name" => ["required", "string"],
            "last_name" => ["required", "string"],
            "mobile" => [
                "required",
                "size:11",
                Rule::unique('teachers')->ignore('id')
            ],
            "address" => ["required"],
            "user_id" => ["required", "int"]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'success'   => false,
                'message'   => 'Validation errors',
                'details'      => $validator->errors(),
                'code'      => 400
            ],
            400
        ));
    }
}
