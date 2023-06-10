<?php

namespace App\GraphQL\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

final class CreateStudentWarningInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        //Log::info("the args is : " . $this->arg );
        return [
            "course_id" => [
                "nullable",
                "exists:courses,id"
            ]
        ];
    }
}
