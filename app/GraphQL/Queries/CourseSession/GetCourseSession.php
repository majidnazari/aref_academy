<?php

namespace App\GraphQL\Queries\CourseSession;

use App\Models\CourseSession;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;

final class GetCourseSession
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveCourseSessionAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;

        $CourseSession = CourseSession::where('id', $args['id'])
            ->whereHas('course', function ($query) use ($branch_id) {
                if ($branch_id) {
                    $query->where('branch_id', $branch_id);
                }
                return true;
            })->with('course')
            ->first();
        return $CourseSession;
    }
}
