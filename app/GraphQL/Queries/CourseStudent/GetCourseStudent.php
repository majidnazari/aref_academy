<?php

namespace App\GraphQL\Queries\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Log;

final class GetCourseStudent
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveCourseStudentAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        //$user = auth()->guard('api')->user();
        $user = auth()->user();
        //Log::info("the user is:". $user);
        //Log::info("the branch id  is:". $user->branch_id);
        $CourseStudent = CourseStudent::where('id', $args['id'])
            ->whereHas('course', function ($query) use ($user) {
                if ($user->branch_id) {
                    $query->where('branch_id', $user->branch_id);
                }
                return true;
            })->with('course');
        return $CourseStudent;
    }
}
