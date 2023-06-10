<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;
use Illuminate\Validation\Rule;
use App\Models\Course;

final class UpdateCourseStudentInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            // TODO Add your validation rules
            "course_id" => [
                "nullable"

            ],
            "student_id" => [
                "nullable",
                'unique:course_students,student_id,NULL,id,course_id,' . $this->arg('course_id'),
            ],
            'financial_refused_status' => [
                "nullable",
                'in:not_returned,returned,noMoney'
            ],
            "transferred_to_course_id"  => [
                "nullable",
                Rule::in(Course::pluck('id'))
            ],
            "description" => [
                "nullable",
                Rule::requiredIf($this->arg('student_status') == "refused"),
            ]
        ];
    }
}
