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
            $getCourse= Course::where('deleted_at', null); //->orderBy('id','desc');            
            // ->where(function ($query) use ($args) {
            //     if (isset($args['lesson_id']))
            //         $query->where('lessons.id', $args['lesson_id']);
            //     else
            //         return true;
            // })
            // ->with('lesson');
            return $getCourse;
            
        }
        $Course = Course::where('deleted_at', null)
        ->where('id', -1);
        return  $Course;
    }
}
