<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;


class CourseSessionCreateRequest extends FormRequest
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
            "user_id" => ["required","int"],
            "course_id" => ["required","int"],            
            "name" => ["required","string"],
            "start_date" => [
                "required",
                "date_format:Y-m-d"
            ],
            "start_time" => [
                "required",
                "date_format:H:i:s"
                ],
            "end_time" => [
                "required",
                "date_format:H:i:s"
            ],
                     
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
