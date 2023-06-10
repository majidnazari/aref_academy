<?php

namespace App\GraphQL\Queries\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\AbsencePresence;
use App\Models\Branch;
use App\Models\CourseSession;
use AuthRole;


final class GetCourseStudentsWithAbsencePresenceList
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveCourseStudent($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        $branch_id = auth()->guard('api')->user()->branch_id;

        if (AuthRole::CheckAccessibility("GetCourseStudentsWithAbsencePresenceList")) {

            $data = [];
            $students = [];
            $absence_presence_id = 0;
            $session_id_list = CourseSession::where('course_id', $args['course_id'])->where('isCancel', false)->pluck('id');
            $all_course_student_ids = CourseStudent::where('course_id', $args['course_id'])
                ->whereHas('course', function ($query) use ($branch_id) {
                    if ($branch_id) {
                        $query->where('branch_id', $branch_id);
                    }
                    return true;
                })->with('course')
                ->pluck('student_id');
            $student_lists = CourseStudent::where('course_id', $args['course_id']); //->pluck('student_id');
            $get_all_student_sesions = AbsencePresence::whereIn('course_session_id', $session_id_list)
                ->whereIn('student_id', $student_lists->pluck('student_id')) // $all_course_student_ids)
                ->WhereHas('courseSession', function ($q) {
                    $q->where('isCancel', false);
                })
                ->with('courseSession')
                ->orderBy('student_id', 'asc')
                ->get();
            foreach ($student_lists->get() as $student_list) {
                $absence_presences_sessions = [];
                foreach ($get_all_student_sesions as $absence_presence) {
                    if ($absence_presence->student_id == $student_list->student_id) {
                        $absence_presence_id = $absence_presence->id;
                        $absence_presence_tmp =
                            [
                                "status" => $absence_presence->status,
                                "session_id" => $absence_presence->course_session_id,
                                "start_date" => $absence_presence->courseSession->start_date,
                                "start_time" => $absence_presence->courseSession->start_time,
                                "end_time" => $absence_presence->courseSession->end_time,
                            ];

                        $absence_presences_sessions[] = $absence_presence_tmp;
                    }
                }
                usort($absence_presences_sessions, function ($a, $b) {
                    $sa = strtotime($a['start_date']);
                    $sb = strtotime($b['start_date']);
                    return $sa < $sb ? -1 : 1;
                });
                $students[] = [
                    "id" => $absence_presence_id,
                    "student_id" => $student_list->student_id,
                    "student_status" => $student_list->student_status,
                    "sessions" =>
                    $absence_presences_sessions,
                ];
            }

            return $students;
        }

        return null;
    }
}
