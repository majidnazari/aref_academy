<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserEditRequest extends FormRequest
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
            "mobile" => ["nullable","size:11","unique:users,mobile,".$this->id],//[Rule::requiredIf($this->mobile),"nullable","size:11","unique:users,mobile,".$this->id],
            //'role_id' => Rule::requiredIf($request->user()->is_admin),
            "first_name" => ["nullable","string"],
            "last_name" => ["nullable","string"],
            "email" => ["nullable","email","unique:users,email,".$this->id],//[Rule::requiredIf($this->id),"nullable","email","unique:users,email,".$this->id],
            "password" => ["nullable","string"],
            "type" => [
                "nullable",
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
            'data'      => $validator->errors(),
            'code'      =>400
        ],400
        ));
    }
}
