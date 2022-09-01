<?php

namespace App\GraphQL\Mutations\CourseStudent;

use App\Models\AbsencePresence;
use App\Models\CourseStudent;
use Illuminate\Support\Facades\DB;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;

final class CreateCourseStudentAndAbsencePresenceRapidlly
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {

    }
    public function resolver($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver
        $user_id = auth()->guard('api')->user()->id;
        //$tmp=json_encode($args);
        Log::info("the course id is:" . $args['input']['course_id'] );
        $is_exist= CourseStudent::where('course_id',$args['input']['course_id'])
        ->where('student_id',$args['input']['student_id'])
        ->first();
        if($is_exist)
         {
                 return Error::createLocatedError("COURSESTUDENT-CREATE-RECORD_IS_EXIST");
         }
        $CourseStudente = [
            'user_id_creator' =>  $user_id,
            'course_id' => $args['course_id'],
            //'course_session_id' => $args['course_session_id'],
            'student_id' => $args['student_id'],
            'manager_status' => isset($args['status']) ? $args['status'] : 'pending',
            'financial_status' => isset($args['financial_status']) ? $args['financial_status'] : 'pending',
            'student_status' => isset($args['student_status']) ? $args['student_status'] : 'ok',
            'user_id_manager' => isset($args['user_id_manager']) ? $args['user_id_manager'] : 0,
            'user_id_financial' => isset($args['user_id_financial']) ? $args['user_id_financial'] : 0,
            'user_id_student_status' => isset($args['user_id_student_status']) ? $args['user_id_student_status'] :  $user_id,
            
            'user_id_approved' => 0            
        ];
        $CourseStudent_result = CourseStudent::create($CourseStudente);

        $AbsencePresence=[            

            'user_id_creator' => $user_id,
            "course_session_id" => $args['course_session_id'],
            "teacher_id" => isset($args['teacher_id']) ? $args['teacher_id'] : 0, 
            "student_id" => $args['student_id'] ,          
            'status' => isset($args['status']) ?  $args['status'] : 'present',           
            'attendance_status' => isset($args['attendance_status']) ?  $args['attendance_status'] : 'normal',         
            
        ];
        $is_exist=AbsencePresence::where('course_session_id',$args['course_session_id'])        
        ->where('status',$args['status'])
        ->first();
        if($is_exist)
        {
                return Error::createLocatedError("ABSENCEPRESENCE-CREATE-RECORD_IS_EXIST");
        }
        $AbsencePresence=AbsencePresence::create($AbsencePresence);
       

        return DB::table('courses')->where('courses.id',$args['course_id'])
        ->where('CS.deleted_at',null)
        ->where('AB.deleted_at',null)
        ->where('courses.deleted_at',null)
        ->select('courses.id as course_id',
        'AB.id as id',
        'AB.status as ap_status',
        'AB.attendance_status as ap_attendance_status',
        'AB.user_id_creator as ap_user_id_creator',
        'AB.course_session_id as ap_course_session_id',
        'AB.teacher_id as ap_teacher_id',
        'AB.student_id as ap_student_id',
        'AB.created_at as ap_created_at',

        'CS.user_id_creator as cs_user_id_creator',   
        'CS.student_id as student_id',   
        'CS.course_id  as cs_course_id',              
        'CS.manager_status as cs_manager_status',   
        'CS.financial_status as cs_financial_status',   
        'CS.student_status as cs_student_status',   
        'CS.user_id_manager as cs_user_id_manager',   
        'CS.user_id_financial as cs_user_id_financial',   
        'CS.user_id_student_status as cs_user_id_student_status',  
        'CS.created_at as cs_created_at',  
          
        )
        ->leftjoin('course_students AS CS','CS.course_id','=','courses.id')
        ->leftjoin('absence_presences AS AB',function($query) use($args){
            $query->on('AB.student_id','CS.student_id')
            //->where('AB.course_session_id',$args['course_session_id'])
            ->where('AB.deleted_at',null);
            
        })->orderBy('id','asc');

       // return "Successful";

    }
   
}
