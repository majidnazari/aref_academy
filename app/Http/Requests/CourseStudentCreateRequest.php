<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class CourseStudentCreateRequest extends FormRequest
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
            "course_id" => ["required","int"],
            "student_id" => ["required","int"],
            "status" => [
                "required",
                Rule::in(["approved","pending"]),
            ],
            "user_id_created" => ["required","int"],
            "user_id_approved" => ["required","int"],                     
        ];
        
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'details'   => $validator->errors(),
            'code'      => 400
        ], 400
        ));
    }
}
