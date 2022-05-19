<?php

namespace App\GraphQL\Queries\Group;

use App\Models\Group;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

final class GetGroups
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolveGroup($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Group::where('deleted_at', null);//->orderBy('id','desc');
    }
}
