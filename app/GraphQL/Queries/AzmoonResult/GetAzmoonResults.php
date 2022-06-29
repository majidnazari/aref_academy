<?php

namespace App\GraphQL\Queries\AzmoonResult;

use App\Models\AzmoonResult;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class GetAzmoonResults
{
    public function resolveAzmoonResult($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return AzmoonResult::where('deleted_at', null);
    }
}
