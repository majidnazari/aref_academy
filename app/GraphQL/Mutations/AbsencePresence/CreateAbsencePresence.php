<?php

namespace App\GraphQL\Mutations\AbsencePresence;

use App\Events\UpdateCourseStudentStatistics;
use App\Models\AbsencePresence;
use App\Models\CourseSession;
use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;
use CourseStudentReportUpdator;
use Throwable;

final class CreateAbsencePresence
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolver($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $user_id = auth()->guard('api')->user()->id;
        $AbsencePresence = [

            'user_id_creator' => $user_id,
            "course_session_id" => $args['course_session_id'],
            "teacher_id" => $args['teacher_id'],
            "student_id" => $args['student_id'],
            'status' => $args['status'],
            'attendance_status' => $args['attendance_status']

        ];
        $is_exist = AbsencePresence::where('course_session_id', $args['course_session_id'])
            //->where('teacher_id', $args['teacher_id'])
            //->where('status', $args['status'])
            ->where('student_id', $args['student_id'])
            ->first();
        if ($is_exist) {
            return Error::createLocatedError("ABSENCEPRESENCE-CREATE-RECORD_IS_EXIST");
            //return Error::createLocatedError("درج حضور غیاب:رکورد مورد نظر تکراری است.");
        }
        $AbsencePresence = AbsencePresence::create($AbsencePresence);
        $courseSession = CourseSession::where('id', $args['course_session_id'])->where('isCancel',false)->first();
        $params = [
            "course_id" => $courseSession['course_id'],
            "student_id" => $args['student_id'],            
        ];             
        try {
            event(new  UpdateCourseStudentStatistics($params));
        } catch (\Exception $e) {
            
            return Error::createLocatedError('COURSESTUDENTTOTALREPORT_EVENT_LISTENER_HAS_ERROR_CREATE');
            //return Error::createLocatedError('درج حضور غیاب:گزارش دوره های دانش آموز به مشکل خورده است.');
        }
        
        return $AbsencePresence;
    }
    public function resolverAbsencePresenceAllSession($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {

        $user_id = auth()->guard('api')->user()->id;
        $students = AbsencePresence::where('course_session_id', $args['course_session_id'])
            ->pluck('student_id');          
        $getAllcourseStudent = CourseStudent::where('course_id', $args['course_id'])
            ->whereNotIn('student_id', $students)
            ->get();          

        foreach ($getAllcourseStudent as $courseStudent) {
            $s_id = $courseStudent->student_id;
            $AbsencePresence = [
                'user_id_creator' => $user_id,
                "course_session_id" => $args['course_session_id'],
                "teacher_id" => 0,
                "student_id" => $courseStudent->student_id,
                'status' => $courseStudent->student_status=="refused" ? "refused" : "noAction" ,

            ];            
            $AbsencePresence = AbsencePresence::create($AbsencePresence);                      
        }        
        return "successfull";
    }    
}
