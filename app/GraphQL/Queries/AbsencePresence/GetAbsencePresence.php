<?php

namespace App\GraphQL\Queries\AbsencePresence;

use App\Models\AbsencePresence;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;
use AuthRole;
use Log;

final class GetAbsencePresence
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveAbsencePresenceAttribute($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $all_branch_id = Branch::where('deleted_at', null)->pluck('id');
        $branch_id = Branch::where('deleted_at', null)->where('id', auth()->guard('api')->user()->branch_id)->pluck('id');
        $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id;
        $AbsencePresence = AbsencePresence::where('id', $args['id'])
            ->whereHas('courseSession.course', function ($query) use ($branch_id) {
                if ($branch_id != "") {
                    $query->whereIn('branch_id', $branch_id);
                }
                return true;
            })->with('courseSession.course')
            ->first();

        return $AbsencePresence;
    }
    public function resolveGetAbsencePresence($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $branch_id = auth()->guard('api')->user()->branch_id;
        $AbsencePresence = AbsencePresence::where('course_session_id', $rootValue['course_session_id'])
            ->where('student_id', $rootValue['student_id'])
            ->whereHas('courseSession.course', function ($query) use ($branch_id) {
                if ($branch_id) {
                    $query->where('branch_id', $branch_id);
                }
                return true;
            })->with('courseSession.course')
            ->first();
        return $AbsencePresence;
    }
}
