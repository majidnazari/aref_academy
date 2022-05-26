<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class CreateCourseSessionByDuringDateInputValidator extends Validator
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
            'days.*' =>[
                'required',
                'string',
                'max:255',
                'in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday'

            ] ,
            'name' =>
            [
                'nullable',
                'min:6'
            ],            
            'start_date' =>[
                "required",
                'date',
                'date_format:"Y-m-d"'
            ],
            'end_date' =>[
                "required",
                'date',
                'after_or_equal:start_date',
                'date_format:"Y-m-d"'
            ],
            'start_time' =>[
                "required",
                'date_format:"H:i"'
            ],
            'end_time' =>[
                "required",
                'date_format:"H:i"',
                'after:start_time'
            ]
        
        ];
    }
}
