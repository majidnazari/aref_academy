<?php

namespace App\GraphQL\Mutations\AbsencePresence;

use App\Events\UpdateCourseStudentStatistics;
use App\Models\AbsencePresence;
use App\Models\CourseSession;
use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
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
        }
        $AbsencePresence = AbsencePresence::create($AbsencePresence);
        $courseSession = CourseSession::where('id', $args['course_session_id'])->first();
        $params = [
            "course_id" => $courseSession['course_id'],
            "student_id" => $args['student_id'],
            // "total_not_registered" => ($args['status'] == "not_registered") ? 1 : 0,
            // "total_noAction" => ($args['status'] == "noAction") ? 1 : 0,
            // "total_dellay60" => ($args['status'] == "dellay60") ? 1 : 0,
            // "total_dellay45" => ($args['status'] == "dellay45") ? 1 : 0,
            // "total_dellay30" => ($args['status'] == "dellay30") ? 1 : 0,
            // "total_dellay15" => ($args['status'] == "dellay15") ? 1 : 0,
            // "total_present" => ($args['status'] == "present") ? 1 : 0,
            // "total_absent" => ($args['status'] == "absent") ? 1 : 0,
        ];
        //$UpdateCourseStudentReport=CourseStudentReportUpdator::updateTotalReport($params);
        //Log::info("event is fier\n" );       
        try {
            event(new  UpdateCourseStudentStatistics($params));
        } catch (\Exception $e) {
            //Log::info("ex is: " .$e);
            return Error::createLocatedError('COURSESTUDENTTOTALREPORT_EVENT_LISTENER_HAS_ERROR_CREATE');
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
        //Log::info("course is:" .json_encode($getAllcourseStudent));
        //return $getAllcourseStudent;
        // $course_session=CourseSession::where('id',$args['course_session_id'])->first();
        // if($course_session){

        foreach ($getAllcourseStudent as $courseStudent) {
            $s_id = $courseStudent->student_id;
            $AbsencePresence = [
                'user_id_creator' => $user_id,
                "course_session_id" => $args['course_session_id'],
                "teacher_id" => 0,
                "student_id" => $courseStudent->student_id,
                'status' => $courseStudent->student_status=="refused" ? "refused" : "noAction" ,

            ];
            // $params = [
            //     "course_id" => $args['course_id'],
            //     "student_id" => $student->student_id,
            //     // "total_not_registered" => 0,
            //     // "total_noAction" => 1,
            //     // "total_dellay60" =>0,
            //     // "total_dellay45" =>0,
            //     // "total_dellay30" =>0,
            //     // "total_dellay15" =>0,
            //     // "total_present" => 0,
            //     // "total_absent" => 0
            // ];
            //$UpdateCourseStudentReport=CourseStudentReportUpdator::updateTotalReport($params);
            //Log::info("event is fier\n" );       
            // try {
            //     event(new  UpdateCourseStudentStatistics($params));
            // } catch (\Exception $e) {
            //     //Log::info("ex is: " .$e);
            //     return Error::createLocatedError('COURSESTUDENTTOTALREPORT_EVENT_LISTENER_HAS_ERROR_CREATE_ALLSESSION');
            // }
           // $UpdateCourseStudentReport = UpdateCourseStudentReport::updateTotalReport($params);
            // $is_exist=AbsencePresence::where('course_session_id',$args['course_session_id'])
            // ->where('student_id',$s_id)
            // ->first();

            // if(!$is_exist)  
            // {
            $AbsencePresence = AbsencePresence::create($AbsencePresence);
            //continue;
            //return Error::createLocatedError("ABSENCEPRESENCE-CREATE-RECORD_IS_EXIST");
            // }               
        }
        // $this->addNotRegisteredUser($args['course_id'], $user_id);
        //}
        return "successfull";
    }
    // public function addNotRegisteredUser($course_id, $user_id)
    // {
    //     $all_course_session_ids_of_this_course = CourseSession::where('course_id', $course_id)->pluck('id');
    //     $cout_session=0;
    //     foreach ($all_course_session_ids_of_this_course as $course_session_id) {
    //         $cout_session++;
    //         $students = AbsencePresence::where('course_session_id', $course_session_id)
    //             ->pluck('student_id');
    //         $get_all_new_course_student = CourseStudent::where('course_id', $course_id)
    //             ->whereNotIn('student_id', $students)
    //             ->get();
    //             foreach ($get_all_new_course_student as $student) {
    //                 $s_id = $student->student_id;
    //                 $AbsencePresence = [
    //                     'user_id_creator' => $user_id,
    //                     "course_session_id" => $course_session_id,
    //                     "teacher_id" => 0,
    //                     "student_id" => $student->student_id,
    //                     'status' => "not_registered"

    //                 ];
    //                 $AbsencePresence = AbsencePresence::create($AbsencePresence);
    //             }
    //     }

    //     // $students = AbsencePresence::where('course_session_id', $args['course_session_id'])
    //     //     ->pluck('student_id');
    //     // $getAllcourseStudent = CourseStudent::where('course_id', $args['course_id'])
    //     //     ->whereNotIn('student_id', $students)
    //     //     ->get();
    //     // foreach ($getAllcourseStudent as $student) {
    //     //     $s_id = $student->student_id;
    //     //     $AbsencePresence = [
    //     //         'user_id_creator' => $user_id,
    //     //         "course_session_id" => $args['course_session_id'],
    //     //         "teacher_id" => 0,
    //     //         "student_id" => $student->student_id,
    //     //         'status' => "noAction"

    //     //     ];
    //     //     $AbsencePresence = AbsencePresence::create($AbsencePresence);
    //     // }
    // }
}
