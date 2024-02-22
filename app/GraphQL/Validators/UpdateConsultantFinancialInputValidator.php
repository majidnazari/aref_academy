<?php

namespace App\GraphQL\Validators;

use App\Enums\ManagerStatus;
use App\GraphQL\Enums\FinancialRefusedStatusConsultantFinancial;
use App\GraphQL\Enums\FinancialStatusConsultantFinancial;
use App\GraphQL\Enums\ManagerStatusConsultantFinancial as EnumsManagerStatus;
use App\GraphQL\Enums\StudentStatusConsultantFinancial;
use Nuwave\Lighthouse\Validation\Validator;
use Illuminate\Validation\Rule;
use App\Models\Group;
use App\Rules\ManagerRuleToUpdateConsultantFinancial;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

use Log;

final class UpdateConsultantFinancialInputValidator extends Validator
{   
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        $consultant = Group::where('type', 'consultant')->pluck('id')->first();
        $user_type = auth()->guard('api')->user()->group->type;

        //Log::info(implode(',', StudentStatusConsultantFinancial::getValues()));
        //Log::info(implode(',', FinancialRefusedStatusConsultantFinancial::getValues()));

        return [
            // TODO Add your validation rules
            'consultant_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) use ($consultant) {
                    $query->where('group_id', $consultant);
                }),
            ],
            'branch_id' => [
                'nullable',
                Rule::exists('branches', 'id')->where(function ($query) {
                    $query->where('id', $this->arg('branch_id'));
                })

            ],
            'year_id' => [
                "nullable",
                Rule::exists('years', 'id')->where(function ($query) {
                    $query->where('id', $this->arg('year_id'))->where('active', true);
                })
            ],
            'consultant_definition_detail_id' => [
                "nullable",
                Rule::exists('consultant_definition_details', 'id')->where(function ($query) {
                    $query->where('id', $this->arg('consultant_definition_detail_id'));
                })
            ],
            'manager_status' => [
                "nullable",
                //  'in:approved,pending',
                //Rule::in(implode(',', EnumsManagerStatus::getValues())),  
               'rules' => [ 'string', 'in:'.implode(',', EnumsManagerStatus::getValues())],             
                new ManagerRuleToUpdateConsultantFinancial($user_type)
            ],
            'financial_status' => [
                "nullable",
                //'in:approved,pending,semi_approved',
                'rules' => [ 'string', 'in:'.implode(',', FinancialStatusConsultantFinancial::getValues())],
                new ManagerRuleToUpdateConsultantFinancial($user_type)
            ],
            'student_status' => [
                'type' => Type::string(),
                "nullable",
                'rules' => [ 'string', 'in:'.implode(',', StudentStatusConsultantFinancial::getValues())],
                //new ManagerRuleToUpdateConsultantFinancial($user_type)
            ],
            'financial_refused_status' => [
                'type' => Type::string(),
                "nullable",
                'rules' => [ 'string', 'in:'.implode(',', FinancialRefusedStatusConsultantFinancial::getValues())],
                new ManagerRuleToUpdateConsultantFinancial($user_type)
               
            ],
        ];
    }
}
