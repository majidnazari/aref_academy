<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class StudentFaultCreateRequest extends FormRequest
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
            "student_id" => ["required","int"],
            "fault_id" => ["required","int"]
        ];
    }
    public function errorValidation(Validation $validator)
    {
        throw new HttpResponseExection(response()->json(
            [
                "success" => false,
                'message'   => 'Validation errors',
                "details"  =>$validator->errors(),
                'code'      =>400
            ]));
    }
}
