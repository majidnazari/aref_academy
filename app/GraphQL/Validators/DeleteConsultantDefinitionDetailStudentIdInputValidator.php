<?php

namespace App\GraphQL\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

final class DeleteConsultantDefinitionDetailStudentIdInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            "student_id" => [
                "required",
                // Rule::exists('student_warnings', 'student_id')->where(function ($query) {
                //     $query->where('student_id', $this->arg('student_id'));
                // }),

            ],
            // "student" => [
            //     "nullable",

            // ],
            // "response" => [
            //     "required",
            //     "in:done,noAction"
            // ]
        ];
    }
}
