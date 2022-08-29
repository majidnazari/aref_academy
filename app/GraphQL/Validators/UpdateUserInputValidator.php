<?php

namespace App\GraphQL\Validators;

use App\Rules\ManagerRuleToCreateUser;
use App\Rules\ManagerRuleToUpdateUser;
use Nuwave\Lighthouse\Validation\Validator;

final class UpdateUserInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        $user_type=auth()->guard('api')->user()->group->type; 
        return [
            // TODO Add your validation rules
            //'id' => 'required|unique:users',
            //'id' => 'required|exists:App\Models\User,id',
             "id" => [
                 "required",         
            ],
            "group_id" =>[
                "nullable",
                new ManagerRuleToUpdateUser($this->arg('id'),$user_type)
            ],           
            "email" =>[
                "nullable",
                "unique:users,email," . $this->arg('id')              
            ]
            
        ];
    }
}
