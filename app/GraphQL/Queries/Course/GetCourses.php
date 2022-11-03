<?php

namespace App\GraphQL\Queries\Course;

use App\Models\Course;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use AuthRole;
use GraphQL\Error\Error;


final class GetCourses
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function resolveCourse($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (AuthRole::CheckAccessibility("Course")) {
            return Course::where('deleted_at', null) //->orderBy('id','desc');            
                ->whereHas('lesson', function ($query) use ($args) {
                    if (isset($args['lesson_name']))
                        $query->where('lessons.name', 'LIKE', '%' . $args['lesson_name'] . '%');
                    else
                        return true;
                })
                ->with(['lesson' => function ($query) use ($args) {
                    if (isset($args['lesson_name']))
                        $query->where('lessons.name', 'LIKE', '%' . $args['lesson_name'] . '%');
                    else
                        return true;
                }]);
        }
        return Course::where('deleted_at', null)
            ->where('id', -1); 
    }
}
