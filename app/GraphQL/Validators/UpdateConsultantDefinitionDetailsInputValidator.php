<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class UpdateConsultantDefinitionDetailsInputValidator extends Validator
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
            'days' => [
                'required',
                'array'
            ],
            'days.*' => [
                'required',
                'string',
                'max:255',
                'in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday'

            ],
            'start_hour' => [
                "required",
                'date_format:"H:i"'
            ],
            'end_hour' => [
                "required",
                'after:start_hour',
                'date_format:"H:i"'
            ],
            'step' => [
                "required",
                'integer',
                'min:0',
                'max:60'
            ],
            'student_status' => [
                "nullable",
                'in:no_action,absent,present,dellay'
            ],
            
        ];
    }
}
