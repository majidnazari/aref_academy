<?php

namespace App\GraphQL\Validators;

use App\Models\Group;
use Nuwave\Lighthouse\Validation\Validator;
use App\Rules\CheckDaysPassedOrNot;
use Illuminate\Validation\Rule;
use Log;



final class CreateConsultantDefinitionDetailCopyCurrentWeekPlanInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
       $counsultant_id= Group::where('type', 'consultant')->pluck('id')->first();
      // Log::info("consultant id is: " . $counsultant_id);
        return [            
            'consultant_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(function ($query) use ($counsultant_id) {
                    $query->where('group_id',  $counsultant_id);
                    //->where('id', $this->arg('consultant_id'));
                }),
            ],
        ];
    }
}
