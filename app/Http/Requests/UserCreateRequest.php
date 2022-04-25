<?php

namespace App\Http\Requests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCreateRequest extends FormRequest
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
            //"mobile" => ["required","size:11","unique:users,mobile"],
            "first_name" => ["required","string"],
            "last_name" => ["required","string"],
            //"email" => ["required","email","unique:users,email"],
            "email" => ["required","size:11","unique:users,email"],
            "password" => ["required","string"],
            "type" => [
                "required",
                 Rule::in(["admin", "manager","financial","acceptor"]),
             ],
           // "type" => ["required","in(["admin","manager","financial","acceptor"])"]

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
