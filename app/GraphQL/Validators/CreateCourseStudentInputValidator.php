<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;
use Illuminate\Validation\Rule;


final class CreateCourseStudentInputValidator extends Validator
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
                "required"
                
            ],
            "student_id"=> [
                "required",
                Rule::unique('course_students','student_id')
                ->where('deleted_at',null)
                ->where('course_id',$this->arg('course_id'))
                ->ignore($this->arg('id'), 'id')
                //'unique:course_students,student_id,NULL,id,course_id,' . $this->arg('course_id'),
            ]
              
        ];
    }
}
