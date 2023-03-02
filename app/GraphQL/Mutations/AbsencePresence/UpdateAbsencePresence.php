<?php

namespace App\GraphQL\Mutations\AbsencePresence;

use App\Events\UpdateCourseStudentStatistics;
use App\Models\AbsencePresence;
use App\Models\CourseSession;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;

final class UpdateAbsencePresence
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
        $args["user_id_creator"] = $user_id;
        $AbsencePresence = AbsencePresence::where('id', $args['id'])
        ->with('courseSession')
        ->where('isCancel',false)
        ->first();
        $args['student_id']=$AbsencePresence->student_id;
        $args['course_session_id']=$AbsencePresence->course_session_id;
        //Log::info("the result is:" . ($AbsencePresence->student_id));
        //return  $AbsencePresence;
        $old_status = $AbsencePresence->status;

        if (!$AbsencePresence) {
            return Error::createLocatedError('ABSENCEPRESENCE-UPDATE-RECORD_NOT_FOUND');
        }

        //$courseSession = CourseSession::where('id', $AbsencePresence['course_session_id'])->first();
        // $params = [
        //     "course_id" => $AbsencePresence->courseSession->course_id, // $courseSession['course_id'],
        //     "student_id" => $AbsencePresence->student_id, //$AbsencePresence['student_id'],
        //     // "total_not_registered" => ($old_status == "not_registered") ? -1 : 0,
        //     // "total_noAction" => ($old_status == "noAction") ? -1 : 0,
        //     // "total_dellay60" => ($old_status == "dellay60") ? -1 : 0,
        //     // "total_dellay45" => ($old_status == "dellay45") ? -1 : 0,
        //     // "total_dellay30" => ($old_status == "dellay30") ? -1 : 0,
        //     // "total_dellay15" => ($old_status == "dellay15") ? -1 : 0,
        //     // "total_present" => ($old_status == "present") ? -1 : 0,
        //     // "total_absent" => ($old_status == "absent") ? -1 : 0,
        // ];
        //$UpdateCourseStudentReport=CourseStudentReportUpdator::updateTotalReport($params);
        //Log::info("old params is: \n" . json_encode($params) );       
        // try {
        //     event(new  UpdateCourseStudentStatistics($params));
        // } catch (\Exception $e) {
        //     //Log::info("ex is: " .$e);
        //     return Error::createLocatedError('COURSESTUDENTTOTALREPORT-UPDATE-RECORD_NOT_FOUND_OLDVALUE');
        // }

        //return  $AbsencePresence;
        $AbsencePresence_result = $AbsencePresence->fill($args);
        $AbsencePresence->save();

        //$courseSession = CourseSession::where('id', $AbsencePresence['course_session_id'])->first();
        $params = [
            "course_id" => $AbsencePresence->courseSession->course_id,
            "student_id" => $AbsencePresence->student_id,
            // "total_not_registered" => ($AbsencePresence['status'] == "not_registered") ? 1 : 0,
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
            return Error::createLocatedError('COURSESTUDENTTOTALREPORT-UPDATE-RECORD_NOT_FOUND_NEWVALUE');
        }

        return $AbsencePresence_result;
    }
    public function UpdateAbsencePresenceWithStudentIdCourseSessionId($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
      
        $user_id = auth()->guard('api')->user()->id;
        $args["user_id_creator"] = $user_id;
        $AbsencePresence = AbsencePresence::where('course_session_id', $args['course_session_id'])
            ->where('student_id', $args['student_id'])
            ->with('courseSession')
            ->first();

        if (!$AbsencePresence) {
            return Error::createLocatedError('ABSENCEPRESENCE-UPDATE-RECORD_NOT_FOUND_WITH_STUDENT_AND_COURSESESSION');
        }
        $old_status = $AbsencePresence->status;

        $params = [
            "course_id" => $AbsencePresence->courseSession->course_id, // $courseSession['course_id'],
            "student_id" => $AbsencePresence->student_id, //$AbsencePresence['student_id'],
            // "total_not_registered" => ($old_status == "not_registered") ? -1 : 0,
            // "total_noAction" => ($old_status == "noAction") ? -1 : 0,
            // "total_dellay60" => ($old_status == "dellay60") ? -1 : 0,
            // "total_dellay45" => ($old_status == "dellay45") ? -1 : 0,
            // "total_dellay30" => ($old_status == "dellay30") ? -1 : 0,
            // "total_dellay15" => ($old_status == "dellay15") ? -1 : 0,
            // "total_present" => ($old_status == "present") ? -1 : 0,
            // "total_absent" => ($old_status == "absent") ? -1 : 0,
        ];
        //$UpdateCourseStudentReport=CourseStudentReportUpdator::updateTotalReport($params);
        //Log::info("old params is: \n" . json_encode($params) );       
        try {
            event(new  UpdateCourseStudentStatistics($params));
        } catch (\Exception $e) {
            //Log::info("ex is: " .$e);
            return Error::createLocatedError('COURSESTUDENTTOTALREPORT-UPDATE-RECORD_NOT_FOUND_OLDVALUE');
        }

        $AbsencePresence_result = $AbsencePresence->fill($args);
        $AbsencePresence->save();

        $params = [
            "course_id" => $AbsencePresence->courseSession->course_id,
            "student_id" => $AbsencePresence->student_id,
            "total_not_registered" => ($AbsencePresence['status'] == "not_registered") ? 1 : 0,
            "total_noAction" => ($args['status'] == "noAction") ? 1 : 0,
            "total_dellay60" => ($args['status'] == "dellay60") ? 1 : 0,
            "total_dellay45" => ($args['status'] == "dellay45") ? 1 : 0,
            "total_dellay30" => ($args['status'] == "dellay30") ? 1 : 0,
            "total_dellay15" => ($args['status'] == "dellay15") ? 1 : 0,
            "total_present" => ($args['status'] == "present") ? 1 : 0,
            "total_absent" => ($args['status'] == "absent") ? 1 : 0,
        ];

        //$UpdateCourseStudentReport=CourseStudentReportUpdator::updateTotalReport($params);
        //Log::info("event is fier\n" );       
        try {
            event(new  UpdateCourseStudentStatistics($params));
        } catch (\Exception $e) {
            //Log::info("ex is: " .$e);
            return Error::createLocatedError('COURSESTUDENTTOTALREPORT-UPDATE-RECORD_NOT_FOUND_NEWVALUE');
        }

        return $AbsencePresence_result;
    }
}
