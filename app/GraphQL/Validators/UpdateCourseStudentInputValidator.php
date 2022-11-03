<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

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
            "course_id"=>[ 
                "nullable"
                
            ],
            "student_id"=> [
                "nullable",
                'unique:course_students,student_id,NULL,id,course_id,' . $this->arg('course_id'),
            ]
              
        ];
    }
}
