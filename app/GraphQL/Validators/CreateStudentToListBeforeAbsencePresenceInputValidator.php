<?php

namespace App\GraphQL\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;
use App\Rules\CreateLimitationDateForAbsencePresence;


final class CreateStudentToListBeforeAbsencePresenceInputValidator extends Validator
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
            "course_id" => [
                "required",
                "exists:courses,id"
            ],
            "course_session_id" => [
                "required",
                Rule::exists('course_sessions', 'id')->where(function ($query) {
                    $query->where('course_id', $this->arg('course_id'));
                }),
                new CreateLimitationDateForAbsencePresence($this->arg('course_id'),$user_type)

            ]

        ];
    }
}
