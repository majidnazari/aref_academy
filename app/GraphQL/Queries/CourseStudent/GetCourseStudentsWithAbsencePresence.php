<?php

namespace App\GraphQL\Queries\CourseStudent;

use App\Models\CourseStudent;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use App\Exceptions\CustomException;
use App\Models\Branch;
use AuthRole;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\DB;
use Log;

final class GetCourseStudentsWithAbsencePresence
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
        $all_branch_id=Branch::where('deleted_at', null )->pluck('id');
        $branch_id=Branch::where('deleted_at', null )->where('id',auth()->guard('api')->user()->branch_id)->pluck('id');       
        $branch_id = count($branch_id) == 0 ? $all_branch_id   : $branch_id ;

        if (AuthRole::CheckAccessibility("GetCourseStudentsWithAbsencePresence")) {
            return DB::table('courses')->where('courses.id', $args['course_id'])
                ->where('CS.deleted_at', null)
                ->where('AB.deleted_at', null)
                ->where('courses.deleted_at', null)
                ->whereIn('branch_id',$branch_id)
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

                    'SW.id as student_warning_id',
                    'SW.student_id as student_warning_student_id',
                    'SW.course_id as student_warning_course_id',
                    'SW.comment as student_warning_comment',

                )
                ->leftjoin('course_students AS CS', 'CS.course_id', '=', 'courses.id')
                ->leftjoin('absence_presences AS AB', function ($query) use ($args) {
                    $query->on('AB.student_id', 'CS.student_id')
                        ->where('AB.course_session_id', $args['course_session_id'])
                        ->where('AB.deleted_at', null);
                })
                ->leftjoin('student_warnings AS SW', function ($query) use ($args) {
                    $query->on('SW.student_id', 'AB.student_id')
                        ->where(function ($q) use ($args) {
                            $q->where('SW.course_id', $args['course_id'])
                                ->orWhereNull('SW.course_id');    
                        });                        
                });
        }
        return  DB::table('courses')->where('id', -1);      
    }
}
