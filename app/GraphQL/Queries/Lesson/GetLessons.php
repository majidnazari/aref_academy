<?php

namespace App\GraphQL\Queries\Lesson;

use App\Models\Lesson;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;

final class GetLessons
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    
    function resolveLesson($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) 
    {
        return Lesson::where('deleted_at', null);//->orderBy('id','desc');
    }
}
