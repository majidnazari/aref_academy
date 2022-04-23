<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentFaultEditRequest extends FormRequest
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
            "user_id" => ["nullable","int"],
            "student_id" => ["nullable","int"],
            "fault_id" => ["nullable","int"]
        ];
    }
    public function errorValidation(Validator $validator)
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
