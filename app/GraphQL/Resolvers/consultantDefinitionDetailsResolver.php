<?php

namespace App\GraphQL\Resolvers;

use App\Models\ConsultantDefinitionDetail;
use App\Models\ConsultantFinancial;
use App\Models\Menu;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Log;

class consultantDefinitionDetailsResolver
{
    /**
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $builder
     * @param  array<string, mixed>  $whereConditions
     */
    public function getDefinitionDetails($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
       // Log::info("the root is: " .json_encode($rootValue));
        $consultant_definition_details = ConsultantDefinitionDetail::where('consultant_id', $rootValue['consultant_id'])
        ->where('student_id', $rootValue['student_id'])->get();

       // Log::info("and all of definitions:" . json_encode($consultant_definition_details));
        return $consultant_definition_details;
    }
}
