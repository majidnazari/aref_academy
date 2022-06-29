<?php

namespace App\GraphQL\Queries\Azmoon;

use App\Models\Azmoon;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

final class GetAzmoons
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolveAzmoon($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Azmoon::where('deleted_at', null);//->orderBy('id','desc');
    }
}
