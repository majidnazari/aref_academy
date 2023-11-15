<?php

namespace App\GraphQL\Mutations\CourseStudent;

use App\Events\UpdateCourseStudentStatistics;
use App\Models\AbsencePresence;
use App\Models\CourseSession;
use App\Models\CourseStudent;
use Carbon\Carbon;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;

final class CreateCourseStudent
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
        $is_exist= CourseStudent::where('course_id',$args['course_id'])
        ->where('student_id',$args['student_id'])
        ->first();
       
        $CourseStudente = [
            'course_id' => $args['course_id'],
            //'course_session_id' => $args['course_session_id'],
            'student_id' => $args['student_id'],
            'manager_status' => isset($args['status']) ? $args['status'] : 'pending',
            'financial_status' => isset($args['financial_status']) ? $args['financial_status'] : 'pending',
            'student_status' => isset($args['student_status']) ? $args['student_status'] : 'ok',
            'user_id_manager' => isset($args['user_id_manager']) ? $args['user_id_manager'] : 0,
            'user_id_financial' => isset($args['user_id_financial']) ? $args['user_id_financial'] : 0,
            'user_id_student_status' => isset($args['user_id_student_status']) ? $args['user_id_student_status'] :  $user_id,
            'description' => isset($args['description']) ? $args['description'] : "",
            
            'user_id_creator' =>  $user_id,
            'user_id_approved' => 0            
        ];        
        $CourseStudent_result = CourseStudent::create($CourseStudente);
        $this->addNotRegisteredUser($args['course_id'], $user_id);
        return $CourseStudent_result;
    }

    public function addNotRegisteredUser($course_id, $user_id)
    {       
        $current_date=Carbon::now()->format('Y-m-d');
        $current_time=Carbon::now()->format('H:i:s');      

        $all_course_session_ids_of_this_course = CourseSession::
        where('course_id', $course_id)
        ->where(function ($q) use ($current_date, $current_time) {
            $q->where('start_date','<',$current_date )
            ->orWhere(function($query) use($current_date,$current_time){
                $query->where('start_date','=',$current_date)
                ->where('end_time','<',$current_time);
            }) ;
        })      
        ->pluck('id');        
        $cout_session=0;
        foreach ($all_course_session_ids_of_this_course as $course_session_id) {
            $cout_session++;
            $students = AbsencePresence::where('course_session_id', $course_session_id)
                ->pluck('student_id');
            $get_all_new_course_student = CourseStudent::where('course_id', $course_id)
            
                ->whereNotIn('student_id', $students)
                ->get();
                foreach ($get_all_new_course_student as $student) {
                    $s_id = $student->student_id;
                    $AbsencePresence = [
                        'user_id_creator' => $user_id,
                        "course_session_id" => $course_session_id,
                        "teacher_id" => 0,
                        "student_id" => $student->student_id,
                        'status' => "not_registered"
        
                    ];
                    $AbsencePresence = AbsencePresence::create($AbsencePresence);
                    $params = [
                        "course_id" => $course_id,
                        "student_id" => $student->student_id,                       
                    ];                      
                    try {
                        event(new  UpdateCourseStudentStatistics($params));
                    } catch (\Exception $e) {                       
                        return Error::createLocatedError('COURSESTUDENTNOTREGISTERED-CREATE-RECORD_HAS_ERROR');
                        //return Error::createLocatedError('ایجادجلسات دانش آموز: خطا در هنگام ثبت.');
                    }
                }
        }

    }
}
