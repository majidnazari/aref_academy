<?php

namespace App\GraphQL\Queries\Year;

use App\Models\Year;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

final class GetYears
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    
    function resolveYear($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        return Year::where('deleted_at', null);
    }
}
