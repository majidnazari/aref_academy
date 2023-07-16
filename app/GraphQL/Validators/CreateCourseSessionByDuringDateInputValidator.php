<?php

namespace App\GraphQL\Validators;

use Carbon\Carbon;
use Nuwave\Lighthouse\Validation\Validator;
use Illuminate\Validation\Rule;


final class CreateCourseSessionByDuringDateInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        $branch_id=auth()->user()->branch_id;
        $now=Carbon::now()->format("Y-m-d");
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
            'name' =>
            [
                'nullable',
                'min:6'
            ],
            'branch_class_room_id' =>
            [
                'nullable',
                $branch_id===null
                ? Rule::exists('branch_class_rooms', 'id') 
                : Rule::exists('branch_class_rooms', 'id')->where('branch_id',$branch_id)                  

            ],
            'course_id' =>
            [
                'required',
                $branch_id===null
                ? Rule::exists('courses', 'id') 
                : Rule::exists('courses', 'id')->where('branch_id',$branch_id)                  

            ],
           
            'start_date' => [
                "required",
                'date',
                'date_format:"Y-m-d"',
                "after_or_equal: $now"
                           
            ],
            'end_date' => [
                "required",
                'date',
                'after_or_equal:start_date',
                'date_format:"Y-m-d"'
            ],
            'start_time' => [
                "required",
                'date_format:"H:i"'
            ],
            'end_time' => [
                "required",
                'date_format:"H:i"',
                'after:start_time'
            ]
        ];
    }
}
