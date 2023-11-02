<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class UpdateConsultantDefinitionDetailHasStudentInputValidator extends Validator
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
            "student_id" =>[
                "required",
                //Rule::exist()
            ],            
            'student_status' => [
                "nullable",
                'in:no_action,absent,present,dellay5,dellay10,dellay15,dellay15more'
            ],
            'session_status' => [
                "nullable",
                'in:no_action,earlier_5min_finished,earlier_10min_finished,earlier_15min_finished,earlier_15min_more_finished,later_5min_started,later_10min_started,later_15min_started,later_15min_more_started'
            ],
            'consultant_status' => [
                "nullable",
                'in:no_action,absent,present,dellay5,dellay10,dellay15,dellay15more'
            ],
        ];
    }
}
