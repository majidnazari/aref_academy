<?php

namespace App\GraphQL\Validators;

use App\Rules\ManagerRuleToCreateUser;
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
        $user_type = auth()->guard('api')->user()->group->type;
        return [
            "group_id" => [
                "required",
                new ManagerRuleToCreateUser($user_type)
            ],
            "branch_id" => [
                "required",
            ],
            "email" => [
                "required",
                "unique:users,email"
            ],
            "password" => [
                "required",
                "min:8"
            ],
            "first_name" => [
                "required",
            ],
            "last_name" => [
                "required",
            ]
        ];
    }
}
