<?php

namespace App\GraphQL\Mutations\CourseStudent;

use App\Models\AbsencePresence;
use App\Models\CourseStudent;
use Illuminate\Support\Facades\DB;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class CreateCourseStudentAndAbsencePresenceRapidly
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
        $user_id = auth()->guard('api')->user()->id;

        $is_exist_course_student = CourseStudent::where('course_id', $args['input']['course_id'])
            ->where('student_id', $args['input']['student_id'])
            ->first();

        if (!$is_exist_course_student) {
            $CourseStudente_params = [
                'user_id_creator' =>  $user_id,
                'course_id' => $args['input']['course_id'],
                //'course_session_id' => $args['course_session_id'],
                'student_id' => $args['input']['student_id'],
                'manager_status' => isset($args['input']['status']) ? $args['input']['status'] : 'pending',
                'financial_status' => isset($args['input']['financial_status']) ? $args['input']['financial_status'] : 'pending',
                'student_status' => isset($args['input']['student_status']) ? $args['input']['student_status'] : 'ok',
                'user_id_manager' => isset($args['input']['user_id_manager']) ? $args['input']['user_id_manager'] : 0,
                'user_id_financial' => isset($args['input']['user_id_financial']) ? $args['input']['user_id_financial'] : 0,
                'user_id_student_status' => isset($args['input']['user_id_student_status']) ? $args['input']['user_id_student_status'] :  $user_id,

                'user_id_approved' => 0

            ];
            $this->createModel("CourseStudent", $CourseStudente_params);
        }
        $is_exist_absence_presence = $this->isExist("AbsencePresence", $params = [
            "student_id" => $args['input']['student_id'],
            "status" => "present"
        ]);
        if (!$is_exist_absence_presence) {
            $AbsencePresence_param = [

                'user_id_creator' => $user_id,
                "course_session_id" => $args['input']['course_session_id'],
                "teacher_id" => isset($args['input']['teacher_id']) ? $args['input']['teacher_id'] : 0,
                "student_id" => $args['input']['student_id'],
                'status' => isset($args['input']['status']) ? $args['input']['status'] : 'present',
                'attendance_status' => isset($args['input']['attendance_status']) ?  $args['input']['attendance_status'] : 'normal',

            ];
            $this->createModel("AbsencePresence", $AbsencePresence_param);
        }

        return $this->showAbsencePresence($args);
    }

    function isExist($class, $params)
    {
        $fullclassname = 'App\Models' . '\\' . $class;
        $clause = (" where('id','>',1)");
        foreach ($params as $name => $value) {
            $clause .= ("->where('$name' , '$value')");
        }
        $clause .= ("->first();");
        $result = eval("return  $fullclassname::$clause ;");
        if ($result) {
            return true;
        }

        return false;        
    }
    function createModel($class, $params)
    {
        $fullclassname = 'App\Models' . '\\' . $class;
       
        if (class_exists($fullclassname)) {
            $param_tmp = "[ ";
            foreach ($params as $key => $value) {
                $param_tmp .= "'" . $key . "'";
                $param_tmp .= " => ";
                $param_tmp .= "'" . $value . "'";
                $param_tmp .= " , ";                
            }
            $param_tmp .= " ]";
            $result = eval("return  $fullclassname::create($param_tmp);");           
            if ($result) {
                return $result;
            }
            return false;
        }
        return false;

    }
    function createCourseStudent(array $args, int $user_id)
    {
        $CourseStudente = [
            'user_id_creator' =>  $user_id,
            'course_id' => $args['input']['course_id'],
            //'course_session_id' => $args['course_session_id'],
            'student_id' => $args['input']['student_id'],
            'manager_status' => isset($args['input']['status']) ? $args['input']['status'] : 'pending',
            'financial_status' => isset($args['input']['financial_status']) ? $args['input']['financial_status'] : 'pending',
            'student_status' => isset($args['input']['student_status']) ? $args['input']['student_status'] : 'ok',
            'user_id_manager' => isset($args['input']['user_id_manager']) ? $args['input']['user_id_manager'] : 0,
            'user_id_financial' => isset($args['input']['user_id_financial']) ? $args['input']['user_id_financial'] : 0,
            'user_id_student_status' => isset($args['input']['user_id_student_status']) ? $args['input']['user_id_student_status'] :  $user_id,

            'user_id_approved' => 0
        ];
        $CourseStudent_result = CourseStudent::create($CourseStudente);
    }
    // function createAbsencePresence()
    // {
    //     $AbsencePresence = [
    //         'user_id_creator' => $user_id,
    //         "course_session_id" => $args['input']['course_session_id'],
    //         "teacher_id" => isset($args['input']['teacher_id']) ? $args['input']['teacher_id'] : 0,
    //         "student_id" => $args['input']['student_id'],
    //         'status' => isset($args['input']['status']) ? $args['input']['status'] : 'present',
    //         'attendance_status' => isset($args['input']['attendance_status']) ?  $args['input']['attendance_status'] : 'normal',

    //     ];
    // }
    function showAbsencePresence(array $args)
    {
        return DB::table('courses')->where('courses.id', $args['input']['course_id'])
            ->where('CS.deleted_at', null)
            ->where('AB.deleted_at', null)
            ->where('courses.deleted_at', null)
            ->whereNotNull('AB.id')
            ->select(
                'courses.id as course_id',
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
            ->leftjoin('course_students AS CS', 'CS.course_id', '=', 'courses.id')
            ->leftjoin('absence_presences AS AB', function ($query) use ($args) {
                $query->on('AB.student_id', 'CS.student_id')
                    ->where('AB.course_session_id', $args['input']['course_session_id'])
                    ->where('AB.deleted_at', null);
            })->orderBy('id', 'asc');
    }
}
