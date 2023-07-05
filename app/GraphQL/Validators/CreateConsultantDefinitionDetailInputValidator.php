<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;
use App\Rules\CheckDaysPassedOrNot;
use Illuminate\Validation\Rule;



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
            'days.*' => [
                'required',
                'string',
                'max:255',
                'in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday'

            ],
            'week' => [
                'required',
                'in:Current,Next',
                new CheckDaysPassedOrNot($this->arg('days'), $this->arg('start_hour'))

            ],
            // 'name' =>
            // [
            //     'nullable',
            //     'min:6'
            // ],            
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
            'branch_class_room_id' => [
                "nullable",
                Rule::exists('branch_class_rooms', 'id')->where(function ($query) {
                    $query->where('id', $this->arg('branch_class_room_id'))
                    ->where("deleted_at" ,null);
                })
            ],


        ];
    }
}
