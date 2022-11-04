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
            $course= Course::where('deleted_at', null) //->orderBy('id','desc');            
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

                return $course;
        }
        return Course::where('deleted_at', null)
            ->where('id', -1); 
    }
    function resolveCourse2($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        if (AuthRole::CheckAccessibility("GetCourses2")) {

            $data = [];
            $students = [];
            $absence_presence_id=0;
            $course=Course::where('id', $args['course_id'])           
            ->with('teacher')
            ->with('courseSession')
            ->with('courseSession.absencePresences')
            ->whereHas('courseStudent',function($query) use($args){
                if (isset($args['student_status']))
                $query->where('student_status',$args['student_status']);
                if (isset($args['financial_status']))
                $query->where('financial_status',$args['financial_status']);
                if (isset($args['manager_status']))
                $query->where('manager_status',$args['manager_status']);
                else
                return true;
                
            })
            ->with(['courseStudent' => function($query) use($args){
                if (isset($args['student_status']))
                $query->where('student_status',$args['student_status']);
                if (isset($args['financial_status']))
                $query->where('financial_status',$args['financial_status']);
                if (isset($args['manager_status']))
                $query->where('manager_status',$args['manager_status']);
                else
                return true;
            }]);
            // $session_id_list = CourseSession::where('course_id', $args['course_id'])->pluck('id');
            // $all_course_student_ids=CourseStudent::where('course_id', $args['course_id'])->pluck('student_id');
            // $student_lists = CourseStudent::where('course_id', $args['course_id']);//->pluck('student_id');
            // $get_all_student_sesions = AbsencePresence::whereIn('course_session_id', $session_id_list)
            //     ->whereIn('student_id',$student_lists->pluck('student_id'))// $all_course_student_ids)
            //     ->with('courseSession')
            //     ->orderBy('student_id', 'asc')
            //     ->get();
            // foreach ($student_lists->get() as $student_list ) {
            //     $absence_presences_sessions = [];
            //     foreach ($get_all_student_sesions as $absence_presence) {
            //         if ($absence_presence->student_id == $student_list->student_id) {
            //             $absence_presence_id=$absence_presence->id;
            //             $absence_presence_tmp =
            //                 [
            //                     "status" => $absence_presence->status,
            //                     "session_id" => $absence_presence->course_session_id,
            //                     "start_date" =>$absence_presence->courseSession->start_date,
            //                     "start_time" =>$absence_presence->courseSession->start_time,
            //                     "end_time" =>$absence_presence->courseSession->end_time,
            //                 ];

            //             $absence_presences_sessions[] = $absence_presence_tmp;
            //         }
            //     }
            //     usort($absence_presences_sessions, function ($a, $b) {
            //         $sa = strtotime($a['start_date']);
            //         $sb = strtotime($b['start_date']);
            //         return $sa < $sb ? -1 : 1;
            //     });
            //     $students[] = [
            //         "id" =>$absence_presence_id,
            //         "student_id" => $student_list->student_id,
            //         "student_status" => $student_list->student_status,
            //         "sessions" => 
            //             $absence_presences_sessions
            //         ,
            //     ];
            // }
          
            // return $students;

            return $course;
           
        }
        return Course::where('deleted_at', null)
        ->where('id', -1); 
        //return null;
    }
}
