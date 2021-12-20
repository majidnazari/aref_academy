<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GroupCreateRequest extends FormRequest
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
            "user_id" =>["required","int"],
            "name" =>["required","string"],
        ];
    }
    public function errorValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                "details" => $validator->errors(),
                "success" => false,
                'message'   => 'Validation errors',
                "code" => 400
            ]
        ));
    }
}
