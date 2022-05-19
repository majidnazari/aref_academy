<?php

namespace App\GraphQL\Queries\AzmoonResult;

use App\Models\AzmoonResult;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

final class GetAzmoonResults
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolveAzmoonResult($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return AzmoonResult::where('deleted_at', null);//->orderBy('id','desc');
    }
}
