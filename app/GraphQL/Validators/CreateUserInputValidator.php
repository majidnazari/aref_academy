<?php

namespace App\GraphQL\Validators;

use App\Rules\ManagerRuleToCreateUser;
use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

final class CreateUserInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        $user_type=auth()->guard('api')->user()->group->type; 
        //$checkAccessibility= new ManagerRuleToCreateUser($this->group_id,$user_type) ;

        return [
            // TODO Add your validation rules

            "group_id" =>[
                "required",
                new ManagerRuleToCreateUser($user_type)
            ],
            "branch_id" =>[
                "required",
            ],
            "email" =>[
                "required",
                "unique:users,email"
                //Rule::exists("users","email")
            ],
            "password" =>[
                "required",
                "min:8"
            ],
            "first_name" =>[
                "required",               
            ],
            "last_name" =>[
                "required",                
            ]
        ];
    }
}
