<?php

namespace App\GraphQL\Queries\ConsultantFinancial;

use App\Models\ConsultantFinancial;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class GetConsultantFinancial
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveConsultantFinancialAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;
        $ConsultantFinancial = ConsultantFinancial::where('id', $args['id']);

        if ($branch_id) {
            return  $ConsultantFinancial->where('branch_id', $branch_id)->first();
        }

        return $ConsultantFinancial->first();
    }
}
