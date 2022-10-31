<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class CreateCourseInputValidator extends Validator
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
            "branch_id"=>[ 
                "required"
                
            ],
            "year_id"=> [
                "required",
                //'unique:course_students,student_id,NULL,id,course_id,' . $this->arg('course_id'),
            ],
            "teacher_id"=>[ 
                "required"
                
            ],
            "name"=>[ 
                "required"
                
            ],
            "gender"=>[ 
                "required"
                
            ],
            "lesson_id"=>[ 
                "required"
                
            ],
            "education_level"=>[ 
                "required"
                
            ],
            "type"=>[ 
                "required"
                
            ],
              
        ];
    }
}
