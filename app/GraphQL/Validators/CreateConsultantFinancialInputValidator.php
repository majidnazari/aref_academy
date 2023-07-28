<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;
use Illuminate\Validation\Rule;
use App\Models\Group;
use Log;

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
        // Log::info("the  year_id  is:".  $year_id);
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
                }),
            //     Rule::unique('consultant_financials')->where(function ($query){
            //         $query->where('consultant_id',$this->arg('consultant_id'))
            //         ->where('year_id',$this->arg('year_id'))
            //         ->where('branch_id',$this->arg('branch_id'))
            //         ->where('consultant_definition_detail_id',$this->arg('consultant_definition_detail_id'))                   
            //     ->where('deleted_at', null) ;              
            //    // ->ignore($this->arg('id'), 'id');
            //     }),
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
