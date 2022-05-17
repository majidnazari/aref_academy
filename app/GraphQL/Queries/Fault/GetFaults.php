<?php

namespace App\GraphQL\Queries\Fault;

use App\Models\Fault;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

final class GetFaults
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    function resolveFault($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        $Fault= Fault::where('deleted_at', null)->orderBy('id','desc');
        return $Fault;
    }
}
