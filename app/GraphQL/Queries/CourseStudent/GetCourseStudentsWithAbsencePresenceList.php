<?php

namespace App\GraphQL\Queries\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\AbsencePresence;
use App\Models\CourseSession;
use AuthRole;
use GraphQL\Error\Error;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Log;

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
        if (AuthRole::CheckAccessibility("GetCourseStudentsWithAbsencePresenceList")) {

            $data = [];
            $students = [];
            $absence_presence_id=0;
            $session_id_list = CourseSession::where('course_id', $args['course_id'])->pluck('id');
            $student_list = CourseStudent::where('course_id', $args['course_id'])->pluck('student_id');
            $get_all_student_sesions = AbsencePresence::whereIn('course_session_id', $session_id_list)
                ->whereIn('student_id', $student_list)
                ->with('courseSession')
                ->orderBy('student_id', 'asc')
                ->get();
            foreach ($student_list as $student_id) {
                $absence_presences_sessions = [];
                foreach ($get_all_student_sesions as $absence_presence) {
                    if ($absence_presence->student_id == $student_id) {
                        $absence_presence_id=$absence_presence->id;
                        $absence_presence_tmp =
                            [
                                "status" => $absence_presence->status,
                                "session_id" => $absence_presence->course_session_id,
                                "start_date" =>$absence_presence->courseSession->start_date,
                                "start_time" =>$absence_presence->courseSession->start_time,
                                "end_time" =>$absence_presence->courseSession->end_time,
                            ];

                        $absence_presences_sessions[] = $absence_presence_tmp;
                    }
                }
                $students[] = [
                    "id" =>$absence_presence_id,
                    "student_id" => $student_id,
                    "sessions" => 
                        $absence_presences_sessions
                    ,
                ];
            }
            // $data[]= $students;
            // $collection=new Collection([
            //     $students
            // ]);

            return $students;

            // return DB::table('courses')->where('courses.id',$args['course_id'])
            // ->where('CS.deleted_at',null)
            // ->where('AB.deleted_at',null)
            // ->where('courses.deleted_at',null)
            // ->select('courses.id as course_id',
            // 'AB.id as id',
            // 'AB.status as ap_status',
            // 'AB.attendance_status as ap_attendance_status',
            // 'AB.user_id_creator as ap_user_id_creator',
            // 'AB.course_session_id as ap_course_session_id',
            // 'AB.teacher_id as ap_teacher_id',
            // 'AB.student_id as ap_student_id',
            // 'AB.created_at as ap_created_at',

            // 'CS.user_id_creator as cs_user_id_creator',   
            // 'CS.student_id as student_id',   
            // 'CS.course_id  as cs_course_id',              
            // 'CS.manager_status as cs_manager_status',   
            // 'CS.financial_status as cs_financial_status',   
            // 'CS.student_status as cs_student_status',   
            // 'CS.user_id_manager as cs_user_id_manager',   
            // 'CS.user_id_financial as cs_user_id_financial',   
            // 'CS.user_id_student_status as cs_user_id_student_status',  
            // 'CS.created_at as cs_created_at',  

            // )
            // ->leftjoin('course_students AS CS','CS.course_id','=','courses.id')
            // ->leftjoin('absence_presences AS AB',function($query) use($args){
            //     $query->on('AB.student_id','CS.student_id')
            //     //->where('AB.course_session_id',$args['course_session_id'])
            //     ->where('AB.deleted_at',null);

            // })->orderBy('id','asc');
        }
        //return  DB::table('courses')->where('id',-1);

        return null;
    }
}
