<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class CreateConsultantDefinitionDetailInputValidator extends Validator
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
                'in:saturday,sunday,monday,thursday,wednesday,thursday,friday'

            ] ,
            // 'name' =>
            // [
            //     'nullable',
            //     'min:6'
            // ],            
            'start_hour' =>[
                "required",                
                'date_format:"H:i"'
            ],
            'end_hour' =>[
                "required",                
                'after:start_hour',
                'date_format:"H:i"'
            ],
            'step' =>[
                "required",                
                'integer',
                'min:0',
                'max:60'
            ],
            // 'start_time' =>[
            //     "required",
            //     'date_format:"H:i"'
            // ],
            // 'end_time' =>[
            //     "required",
            //     'date_format:"H:i"',
            //     'after:start_time'
            // ]
        
        ];
    }
}
