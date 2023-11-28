<?php

namespace App\GraphQL\Validators;

use App\Models\Group;
use App\Rules\ManagerRuleToUpdateUser;
use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

final class ConsultantDefinitionDetailGeneralReportValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        $user_type = auth()->guard('api')->user()->group->type;
        $consultant = Group::where('type', 'consultant')->pluck('id')->first(); 
        return [
            "consultant_id" => [
                "nullable",
                Rule::exists('users', 'id')->where(function ($query) use ($consultant) {
                    $query->where('group_id', $consultant);
                }),
            ],
            "session_date_from" => [
                "required",
                "date"
                
            ],
            "session_date_to" => [
                "required",
                "date",
                "after:session_date_from +1 month"
            ]
        ];
    }
}
