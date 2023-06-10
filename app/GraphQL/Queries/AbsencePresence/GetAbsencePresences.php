<?php

namespace App\GraphQL\Queries\AbsencePresence;

use App\Models\AbsencePresence;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Branch;
use AuthRole;


final class GetAbsencePresences
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }


    function resolveAbsencePresence($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $all_branch_id = Branch::where('deleted_at', null)->pluck('id');
        $branch_id = Branch::where('deleted_at', null)->where('id', auth()->guard('api')->user()->branch_id)->pluck('id');
        $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id;

        if (AuthRole::CheckAccessibility("AbsencePresence")) {
            $AbsencePresence = AbsencePresence::where('deleted_at', null)
                ->whereHas('courseSession.course', function ($query) use ($branch_id) {
                    if ($branch_id != "") {
                        $query->whereIn('branch_id', $branch_id);
                    }
                    return true;
                })->with('courseSession.course')
                ->whereHas('user', function ($query) use ($args) {
                    if (isset($args['user_id_creator'])) {
                        $query->where('users.id', $args['user_id_creator']);
                    }
                    return true;
                })
                ->with('user')
                ->whereHas('teacher', function ($query) use ($args) {
                    if (isset($args['teacher_id']))
                        $query->where('users.id', $args['teacher_id']);
                    else
                        return true;
                })
                ->with('teacher')
                ->whereHas('courseSession', function ($query) use ($args) {
                    if (isset($args['course_session_id']))
                        $query->where('course_sessions.id', $args['course_session_id']);
                    if (isset($args['course_session_date'])) {
                        $query->where('course_sessions.start_date', $args['course_session_date']);
                    } else
                        return true;
                })
                ->with('courseSession');


            return $AbsencePresence;
        }
        $AbsencePresence = AbsencePresence::where('deleted_at', null)
            ->where('id', -1);
        return  $AbsencePresence;
    }
}
