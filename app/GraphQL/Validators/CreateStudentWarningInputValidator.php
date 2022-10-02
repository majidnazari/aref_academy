<?php

namespace App\GraphQL\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;
use Log;

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
            // TODO Add your validation rules
            // "student_warning_student_id" => [
            //     "required",                
            //     Rule::exists('student_warnings','student_id')->where(function ($query){
            //         $query->where('student_id',$this->arg('student_warning_student_id'));
            //         //->where('id',$this->arg('course_session_id'));
                    
            //     }),

            // ],
            "course_id" => [
                "nullable",
                "exists:courses,id"
            ]            
        ];
    }
}
