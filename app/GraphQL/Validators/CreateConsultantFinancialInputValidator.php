<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;
use Illuminate\Validation\Rule;
use App\Models\Group;

final class CreateConsultantFinancialInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        $consultant = Group::where('type', 'consultant')->pluck('id')->first();
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
                "required",
                Rule::exists('years', 'id')->where(function ($query) {
                    $query->where('id', $this->arg('year_id'))->where('active', true);
                })
            ],
            'consultant_definition_detail_id' => [
                "required",
                Rule::exists('consultant_definition_details', 'id')->where(function ($query) {
                    $query->where('id', $this->arg('consultant_definition_detail_id'));
                })
            ],
            'manager_status' => [
                "nullable",
                'in:approved,pending'
            ],
            'financial_status' => [
                "nullable",
                'in:approved,pending,semi_approved'
            ],
            'student_status' => [
                "nullable",
                'in:ok,refused,fired,financial_pending'
            ],
            'financial_refused_status' => [
                "nullable",
                'in:not_returned,returned,noMoney'
            ],
        ];
    }
}
