<?php

namespace App\GraphQL\Validators;

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
        $user_type = auth()->guard('api')->user()->group->type;
        return [
            "id" => [
                "required",
            ],
            "group_id" => [
                "nullable",
                new ManagerRuleToUpdateUser($this->arg('id'), $user_type)
            ],
            "email" => [
                "nullable",
                "unique:users,email," . $this->arg('id')
            ],
            "password" => [
                "nullable",
                "string",
                "min:8"
            ]

        ];
    }
}
