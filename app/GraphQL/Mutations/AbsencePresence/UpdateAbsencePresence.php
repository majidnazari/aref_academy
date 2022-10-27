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
        $user_id=auth()->guard('api')->user()->id;
        $args["user_id_creator"]=$user_id;
        $AbsencePresence=AbsencePresence::find($args['id']);
        
        if(!$AbsencePresence)
        {
            return Error::createLocatedError('ABSENCEPRESENCE-UPDATE-RECORD_NOT_FOUND');
        }
       
        $AbsencePresence_result= $AbsencePresence->fill($args);
        $AbsencePresence->save(); 
        
        $courseSession = CourseSession::where('id', $args['course_session_id'])->first();
        $params = [
            "course_id" => $courseSession['course_id'],
            "student_id" => $args['student_id'],
            "total_not_registered" => ($args['status'] == "not_registered") ? 1 : 0,
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
            return Error::createLocatedError('CourseStudentTOTALREPORT-UPDATE-RECORD_NOT_FOUND1');
        }
       
        return $AbsencePresence_result;

        
    }
    public function UpdateAbsencePresenceWithStudentIdCourseSessionId($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {  
        $user_id=auth()->guard('api')->user()->id;
        $args["user_id_creator"]=$user_id;
        $AbsencePresence=AbsencePresence::where('course_session_id',$args['course_session_id'])
        ->where('student_id',$args['student_id'])
        ->first();
        
        if(!$AbsencePresence)
        {
            return Error::createLocatedError('ABSENCEPRESENCE-UPDATE-RECORD_NOT_FOUND');
        }
       
        $AbsencePresence_result= $AbsencePresence->fill($args);
        $AbsencePresence->save();       
       
        return $AbsencePresence_result;

        
    }
    
}
