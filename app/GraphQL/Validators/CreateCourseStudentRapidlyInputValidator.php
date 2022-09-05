<?php

namespace App\GraphQL\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

final class CreateCourseStudentRapidlyInputValidator extends Validator
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
                "required",
                "exists:courses,id"
            ],
            "course_session_id" =>[
                "required",
               // "exists:course_sessions,id",
                Rule::exists('course_sessions','id')->where(function ($query){
                    $query->where('course_id',$this->arg('course_id'));
                    //->where('id',$this->arg('course_session_id'));
                    
                }),
            ],
            "student_id" => [
                "required",
            ]
        ];
    }
}
