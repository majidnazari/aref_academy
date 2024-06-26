<?php

namespace App\GraphQL\Mutations\AbsencePresence;

use App\Events\UpdateCourseStudentStatistics;
use App\Models\AbsencePresence;
use App\Models\CourseSession;
use GraphQL\Type\Definition\ResolveInfo;
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
        //->where('isCancel',false)
        ->first();
        $args['student_id']=$AbsencePresence->student_id;
        $args['course_session_id']=$AbsencePresence->course_session_id;
        
        $old_status = $AbsencePresence->status;

        if (!$AbsencePresence) {
             return Error::createLocatedError('ABSENCEPRESENCE-UPDATE-RECORD_NOT_FOUND');
            //return Error::createLocatedError('حضور غیاب- رکورد مورد نظر برای به روز رسانی پیدا نشد.');
        }       
        $AbsencePresence_result = $AbsencePresence->fill($args);
        $AbsencePresence->save();        
        $params = [
            "course_id" => $AbsencePresence->courseSession->course_id,
            "student_id" => $AbsencePresence->student_id,           
        ];
       
        try {
            event(new  UpdateCourseStudentStatistics($params));
        } catch (\Exception $e) {           
             return Error::createLocatedError('COURSESTUDENTTOTALREPORT-UPDATE-RECORD_NOT_FOUND_NEWVALUE');
            //return Error::createLocatedError('گزارش دوره های دانش آموز: مقدار جدید در بروز رسانی پیدا نشد.');
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
            //return Error::createLocatedError(' بروز رسانی حضور غیاب: رکورد مورد نظر دانش آموز'.$args['student_id'].' با دوره دانش آموز پیدا نشد.');
        }
        $old_status = $AbsencePresence->status;

        $params = [
            "course_id" => $AbsencePresence->courseSession->course_id, // $courseSession['course_id'],
            "student_id" => $AbsencePresence->student_id, //$AbsencePresence['student_id'],           
        ];         
        try {
            event(new  UpdateCourseStudentStatistics($params));
        } catch (\Exception $e) {           
            return Error::createLocatedError('COURSESTUDENTTOTALREPORT-UPDATE-RECORD_NOT_FOUND_OLDVALUE');
            //return Error::createLocatedError('بروز رسانی حضور غیاب: بروز رسانی مقادیر رکوردهای قدیمی با خطا روبرو شد.');
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
        try {
            event(new  UpdateCourseStudentStatistics($params));
        } catch (\Exception $e) {            
            return Error::createLocatedError('COURSESTUDENTTOTALREPORT-UPDATE-RECORD_NOT_FOUND_NEWVALUE');
            //return Error::createLocatedError('بروز رسانی حضور غیاب : بروز رسانی گزارش دوره های دانش آموز با مقادیر جدید با خطا روبرو شد.');
        }

        return $AbsencePresence_result;
    }
}
