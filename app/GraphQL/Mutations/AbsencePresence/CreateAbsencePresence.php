<?php

namespace App\GraphQL\Mutations\AbsencePresence;

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
            ->where('teacher_id', $args['teacher_id'])
            ->where('status', $args['status'])
            ->first();
        if ($is_exist) {
            return Error::createLocatedError("ABSENCEPRESENCE-CREATE-RECORD_IS_EXIST");
        }
        $AbsencePresence = AbsencePresence::create($AbsencePresence);
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

        foreach ($getAllcourseStudent as $student) {
            $s_id = $student->student_id;
            $AbsencePresence = [
                'user_id_creator' => $user_id,
                "course_session_id" => $args['course_session_id'],
                "teacher_id" => 0,
                "student_id" => $student->student_id,
                'status' => "noAction"

            ];
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
