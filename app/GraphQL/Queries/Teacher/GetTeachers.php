<?php

namespace App\GraphQL\Queries\Teacher;

use App\Models\Teacher;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class GetTeachers
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolveTeacher($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Teacher::where('deleted_at', null);
    }
}
