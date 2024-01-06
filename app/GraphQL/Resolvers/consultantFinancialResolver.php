<?php

namespace App\GraphQL\Resolvers;

use App\Models\ConsultantFinancial;
;
use App\Models\Menu;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Log;

class consultantFinancialResolver
{
    /**
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $builder
     * @param  array<string, mixed>  $whereConditions
     */
    public function getFinancialStudentStatus($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        Log::info("the root is: " .json_encode($rootValue));
        $consultant_financial = ConsultantFinancial::where('consultant_id', $rootValue['consultant_id'])
        ->where('student_id', $rootValue['student_id'])->first();
        return $consultant_financial;
    }
}
