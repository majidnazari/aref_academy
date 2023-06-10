<?php

namespace App\GraphQL\Queries\Fault;

use App\Models\Fault;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class GetFault
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveFaultAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $Fault = Fault::find($args['id']);
        return $Fault;
    }
}
