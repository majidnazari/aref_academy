<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use illuminate\Validation\Rule;

class StudentContactEditRequest extends FormRequest
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
            "user_id" => ["nullable", "int"],
            "student_id" => ["nullable", "int"],
            "absence_presence_id" => ["nullable", "int"],
            "who_answered" => [
                "nullable",
                Rule::in(["father", "mother", "other"])
            ],
            "description" => ["nullable", "string"],
            "is_called_successfull" => ["nullable", "boolean"],

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
